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

use IR\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * Abstract Address Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class AddressManager implements AddressManagerInterface
{    
    /**
     * {@inheritDoc}
     */    
    public function createAddress(CustomerInterface $customer = null)
    {
        $class = $this->getClass();
        $address = new $class;
        $address->setCustomer($customer);

        return $address;
    }   
}
