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
use IR\Bundle\CustomerBundle\Model\Address as BaseAddress;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Address extends BaseAddress
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
}
