<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\Functional\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\CustomerBundle\Model\Customer as BaseCustomer;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Customer extends BaseCustomer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $billingAddress;
    
    /**
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $shippingAddress;  
    
    /**
     * @ORM\ManyToMany(targetEntity="Address", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="customers_addresses",
     *      joinColumns={@ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")}
     *  )
     */    
    protected $addresses;     
}
