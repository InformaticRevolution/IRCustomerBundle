<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * Customer Event.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CustomerEvent extends Event
{    
    /**
     * @var CustomerInterface
     */              
    protected $customer; 
    
    
    /**
     * Constructor.
     * 
     * @param CustomerInterface $customer
     */            
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Returns the customer.
     * 
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }  
}