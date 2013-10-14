<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use IR\Bundle\CustomerBundle\IRCustomerEvents;
use IR\Bundle\CustomerBundle\Event\AddressEvent;
use IR\Bundle\CustomerBundle\Model\CustomerInterface;
use IR\Bundle\CustomerBundle\Model\AddressInterface;

/**
 * Controller managing customer's address book.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressController extends ContainerAware
{
    /**
     * List all the customer's addresses.
     */    
    public function listAction()
    {
        $customer = $this->getCustomer();       

        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Address:list.html.'.$this->getEngine(), array(
            'addresses' => $customer->getAddresses(),
        ));
    }

    /**
     * Create a new address: show the new form.
     */    
    public function newAction(Request $request)
    {   
        $customer = $this->getCustomer();
        $address = $this->container->get('ir_customer.manager.address')->createAddress($customer);
        
        $form = $this->container->get('ir_customer.form.address');
        $form->setData($address);
        $form->handleRequest($request); 
                
        if ($form->isValid()) {
            $this->container->get('ir_customer.manager.address')->updateAddress($address);

            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRCustomerEvents::ADDRESS_CREATE_COMPLETED, new AddressEvent($address));            
            
            return new RedirectResponse($this->container->get('router')->generate('ir_customer_address_list'));
        }
        
        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Address:new.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));         
    }    

    /**
     * Edit an address: show the edit form.
     */      
    public function editAction(Request $request, $id)
    {
        $customer = $this->getCustomer(); 
        $address = $this->findAddressById($id);

        if (!$customer->hasAddress($address)) {
            throw new AccessDeniedException(sprintf('The address with id %s does not belong to the customer', $id));
        }

        $form = $this->container->get('ir_customer.form.address');       
        $form->setData($address);
        $form->handleRequest($request); 

        if ($form->isValid()) {
            $this->container->get('ir_customer.manager.address')->updateAddress($address);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRCustomerEvents::ADDRESS_EDIT_COMPLETED, new AddressEvent($address));            
            
            return new RedirectResponse($this->container->get('router')->generate('ir_customer_address_list'));                   
        }
        
        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Address:edit.html.'.$this->getEngine(), array(
            'id' => $id,
            'form' => $form->createView(),
        ));           
    }   

    /**
     * Delete an address.
     */    
    public function deleteAction($id)
    {
        $customer = $this->getCustomer(); 
        $address = $this->findAddressById($id);
        
        if (!$customer->hasAddress($address)) {
            throw new AccessDeniedException(sprintf('The address with id %s does not belong to the customer', $id));
        }        

        $this->container->get('ir_customer.manager.address')->deleteAddress($address);

        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRCustomerEvents::ADDRESS_DELETE_COMPLETED, new AddressEvent($address));        
        
        return new RedirectResponse($this->container->get('router')->generate('ir_customer_address_list'));   
    }    
    
    /**
     * Returns the authenticated customer.
     * 
     * @return CustomerInterface
     * 
     * @throws AccessDeniedException When user is not an instance of CustomerInterface
     */
    protected function getCustomer()
    {
        $customer = $this->container->get('security.context')->getToken()->getUser();
        
        if (!is_object($customer) || !$customer instanceof CustomerInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }  
        
        return $customer;
    }

    /**
     * Finds an address by id.
     *
     * @param mixed $id
     *
     * @return AddressInterface
     * 
     * @throws NotFoundHttpException When address does not exist
     */
    protected function findAddressById($id)
    {
        $address = $this->container->get('ir_customer.manager.address')->findAddressBy(array('id' => $id));

        if (null === $address) {
            throw new NotFoundHttpException(sprintf('The address with id %s does not exist', $id));
        }

        return $address;
    }     
    
    /**
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }    
}
