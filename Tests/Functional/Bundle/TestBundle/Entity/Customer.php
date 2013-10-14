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
     * @ORM\OneToMany(targetEntity="Address", mappedBy="customer", cascade={"all"}, orphanRemoval=true)
     */
    protected $addresses;     
}
