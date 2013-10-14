<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Manager;

use IR\Bundle\CustomerBundle\Model\AddressInterface;
use IR\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * Address Manager Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface AddressManagerInterface
{   
    /**
     * Creates an empty address instance.
     *
     * @return AddressInterface
     */
    public function createAddress(CustomerInterface $customer = null);    

    /**
     * Updates an address.
     *
     * @param AddressInterface $address
     * 
     * @return void
     */
    public function updateAddress(AddressInterface $address);    

    /**
     * Deletes an address.
     *
     * @param AddressInterface $address
     * 
     * @return void
     */
    public function deleteAddress(AddressInterface $address);       
    
    /**
     * Finds an address by the given criteria.
     *
     * @param array $criteria
     *
     * @return AddressInterface
     */
    public function findAddressBy(array $criteria);      
    
    /**
     * Returns the address's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}

