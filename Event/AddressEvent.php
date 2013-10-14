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
use IR\Bundle\CustomerBundle\Model\AddressInterface;

/**
 * Address Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressEvent extends Event
{
    /**
     * @var AddressInterface
     */        
    protected $address;
    
    
   /**
    * Constructor.
    *
    * @param AddressInterface $address
    */         
    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    /**
     * Returns the address.
     * 
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }
}