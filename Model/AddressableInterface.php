<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Addressable Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface AddressableInterface
{
    /**
     * Returns the billing address.
     *
     * @return AddressInterface
     */
    public function getBillingAddress();

    /**
     * Sets the billing address.
     *
     * @param AddressInterface $billingAddress
     */
    public function setBillingAddress(AddressInterface $billingAddress = null);    
    
    /**
     * Returns the shipping address.
     *
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * Sets the shipping address.
     *
     * @param AddressInterface $shippingAddress
     */
    public function setShippingAddress(AddressInterface $shippingAddress = null);    
    
    /**
     * Returns all customer's addresses.
     *
     * @return Collection
     */
    public function getAddresses();

    /**
     * Adds an address to the customer's address book.
     *
     * @param AddressInterface $address
     */
    public function addAddress(AddressInterface $address);
    
    /**
     * Removes an address from the customer's address book.
     *
     * @param AddressInterface $address
     */
    public function removeAddress(AddressInterface $address);    
    
    /**
     * Checks whether customer has given address.
     *
     * @param AddressInterface $address
     *
     * @return Boolean
     */
    public function hasAddress(AddressInterface $address);
}