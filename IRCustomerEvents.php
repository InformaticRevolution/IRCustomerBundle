<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle;

/**
 * Contains all events thrown in the IRCustomerBundle.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class IRCustomerEvents
{
    /**
     * The CUSTOMER_CREATE_COMPLETED event occurs after saving the customer in the customer creation process.
     *
     * The event listener method receives a IR\Bundle\CustomerBundle\Event\CustomerEvent instance.
     */
    const CUSTOMER_CREATE_COMPLETED = 'ir_customer.admin.customer.create.completed';    

    /**
     * The CUSTOMER_EDIT_COMPLETED event occurs after saving the customer in the customer edit process.
     *
     * The event listener method receives a IR\Bundle\CustomerBundle\Event\CustomerEvent instance.
     */
    const CUSTOMER_EDIT_COMPLETED = 'ir_customer.admin.customer.edit.completed';    
    
    /**
     * The CUSTOMER_DELETE_COMPLETED event occurs after deleting the customer.
     *
     * The event listener method receives a IR\Bundle\CustomerBundle\Event\CustomerEvent instance.
     */
    const CUSTOMER_DELETE_COMPLETED = 'ir_customer.admin.customer.delete.completed';     
    
    /**
     * The ADDRESS_CREATE_COMPLETED event occurs after saving the address in the address creation process.
     *
     * The event listener method receives a IR\Bundle\CustomerBundle\Event\AddressEvent instance.
     */
    const ADDRESS_CREATE_COMPLETED = 'ir_customer.address.create.completed';
    
    /**
     * The ADDRESS_EDIT_COMPLETED event occurs after saving the address in the address edit process.
     *
     * The event listener method receives a IR\Bundle\CustomerBundle\Event\AddressEvent instance.
     */
    const ADDRESS_EDIT_COMPLETED = 'ir_customer.address.edit.completed';
    
    /**
     * The ADDRESS_DELETE_COMPLETED event occurs after deleting the address.
     *
     * The event listener method receives a IR\Bundle\CustomerBundle\Event\AddressEvent instance.
     */
    const ADDRESS_DELETE_COMPLETED = 'ir_customer.address.delete.completed';    
}