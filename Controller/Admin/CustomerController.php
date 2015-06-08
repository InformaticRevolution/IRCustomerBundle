<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use IR\Bundle\CustomerBundle\IRCustomerEvents;
use IR\Bundle\CustomerBundle\Event\CustomerEvent;
use IR\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * Controller managing the customers.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CustomerController extends ContainerAware
{
    /**
     * List all the customers.
     */
    public function listAction()
    {
        $customers = $this->container->get('fos_user.user_manager')->findUsers();
        
        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Admin/Customer:list.html.twig', array(
            'customers' => $customers,
        ));        
    }
    
    /**
     * Show customer details.
     */
    public function showAction($id)
    {
        $customer = $this->findCustomerById($id);

        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Admin/Customer:show.html.twig', array(
            'customer' => $customer
        ));
    }    
    
    /**
     * Create a new customer: show the new form.
     */
    public function newAction(Request $request)
    {
        $customer = $this->container->get('fos_user.user_manager')->createUser();
        
        $form = $this->container->get('ir_customer.form.customer');
        $form->setData($customer);
        $form->handleRequest($request);  
        
        if ($form->isValid()) {
            $this->container->get('fos_user.user_manager')->updateUser($customer);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRCustomerEvents::CUSTOMER_CREATE_COMPLETED, new CustomerEvent($customer));              
            
            return new RedirectResponse($this->container->get('router')->generate('ir_customer_admin_customer_show', array('id' => $customer->getId())));             
        }
        
        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Admin/Customer:new.html.twig', array(
            'form' => $form->createView(),
        ));         
    }  
    
    /**
     * Edit a customer: show the edit form.
     */    
    public function editAction(Request $request, $id)
    {
        $customer = $this->findCustomerById($id);
        
        $form = $this->container->get('ir_customer.form.customer');
        $form->setData($customer);
        $form->handleRequest($request);  
        
        if ($form->isValid()) {
            $this->container->get('fos_user.user_manager')->updateUser($customer);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRCustomerEvents::CUSTOMER_EDIT_COMPLETED, new CustomerEvent($customer));            
            
            return new RedirectResponse($this->container->get('router')->generate('ir_customer_admin_customer_show', array('id' => $customer->getId()))); 
        }
        
        return $this->container->get('templating')->renderResponse('IRCustomerBundle:Admin/Customer:edit.html.twig', array(
            'id' => $id,
            'form' => $form->createView(),
        ));         
    }   
    
    /**
     * Delete a customer.
     */
    public function deleteAction($id)
    {
        $customer = $this->findCustomerById($id);
        $this->container->get('fos_user.user_manager')->deleteUser($customer);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');               
        $dispatcher->dispatch(IRCustomerEvents::CUSTOMER_DELETE_COMPLETED, new CustomerEvent($customer));          
        
        return new RedirectResponse($this->container->get('router')->generate('ir_customer_admin_customer_list')); 
    }    
    
    /**
     * Finds a customer by id.
     *
     * @param mixed $id
     *
     * @return CustomerInterface
     * 
     * @throws NotFoundHttpException When customer does not exist
     */
    protected function findCustomerById($id)
    {
        $customer = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $id));

        if (null === $customer) {
            throw new NotFoundHttpException(sprintf('The customer with id "%s" does not exist', $id));
        }

        return $customer;
    }
}
