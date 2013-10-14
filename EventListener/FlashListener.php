<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use IR\Bundle\CustomerBundle\IRCustomerEvents;

/**
 * Flash Listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(
        IRCustomerEvents::CUSTOMER_CREATE_COMPLETED => 'customer.flash.created',
        IRCustomerEvents::CUSTOMER_EDIT_COMPLETED => 'customer.flash.updated',
        IRCustomerEvents::CUSTOMER_DELETE_COMPLETED => 'customer.flash.deleted',        
        IRCustomerEvents::ADDRESS_CREATE_COMPLETED => 'address.flash.created',
        IRCustomerEvents::ADDRESS_EDIT_COMPLETED => 'address.flash.updated',
        IRCustomerEvents::ADDRESS_DELETE_COMPLETED => 'address.flash.deleted',
    );

    /**
     * @var SessionInterface
     */    
    protected $session;
    
    /**
     * @var TranslatorInterface
     */    
    protected $translator;

    
   /**
    * Constructor.
    *
    * @param SessionInterface    $session
    * @param TranslatorInterface $translator
    */            
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */        
    public static function getSubscribedEvents()
    {
        return array(
            IRCustomerEvents::CUSTOMER_CREATE_COMPLETED => 'addSuccessFlash',
            IRCustomerEvents::CUSTOMER_EDIT_COMPLETED => 'addSuccessFlash',
            IRCustomerEvents::CUSTOMER_DELETE_COMPLETED => 'addSuccessFlash',             
            IRCustomerEvents::ADDRESS_CREATE_COMPLETED => 'addSuccessFlash',
            IRCustomerEvents::ADDRESS_EDIT_COMPLETED => 'addSuccessFlash',
            IRCustomerEvents::ADDRESS_DELETE_COMPLETED => 'addSuccessFlash',            
        );
    }

    /**
     * Adds a success flash message.
     * 
     * @param Event $event
     * 
     * @return void
     */            
    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->trans(self::$successMessages[$event->getName()]));
    }

    /**
     * Translates a message.
     * 
     * @param string $message
     * @param array  $params
     * 
     * @return string
     */       
    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'ir_customer');
    }
}