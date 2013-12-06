<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\Manager;

use IR\Bundle\CustomerBundle\Manager\AddressManager;

/**
 * Address Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressManagerTest extends \PHPUnit_Framework_TestCase
{
    const ADDRESS_CLASS = 'IR\Bundle\CustomerBundle\Tests\TestAddress';
 
    /**
     * @var AddressManager
     */
    protected $addressManager;    
    
    
    public function setUp()
    {
        $this->addressManager = $this->getMockForAbstractClass('IR\Bundle\CustomerBundle\Manager\AddressManager');
        
        $this->addressManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::ADDRESS_CLASS));        
    }
    
    public function testCreateAddress()
    {        
        $address = $this->addressManager->createAddress();
        
        $this->assertInstanceOf(static::ADDRESS_CLASS, $address);
    }
}