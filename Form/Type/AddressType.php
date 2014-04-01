<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Form\Type;

use IR\Bundle\AddressBundle\Form\Type\AddressType as BaseAddressType;

/**
 * Address Type.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressType extends BaseAddressType
{
    /**
     * {@inheritDoc}
     */    
    public function getName()
    {
        return 'ir_customer_address';
    }    
}
