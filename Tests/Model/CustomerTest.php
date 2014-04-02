<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\Model;

use IR\Bundle\AddressBundle\Model\AddressInterface;
use IR\Bundle\CustomerBundle\Model\CustomerInterface;

/**
 * Customer Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testEmail()
    {
        $customer = $this->getCustomer();
        
        $this->assertNull($customer->getUsername());
        $this->assertNull($customer->getEmail());
        
        $customer->setEmail('test@example.com');
        
        $this->assertEquals('test@example.com', $customer->getUsername());
        $this->assertEquals('test@example.com', $customer->getEmail());
    }
    
    public function testBillingAddress()
    {
        $customer = $this->getCustomer();
        $billingAddress = $this->getAddress();
        
        $this->assertNull($customer->getBillingAddress());
        $this->assertNotContains($billingAddress, $customer->getAddresses());
        
        $customer->setBillingAddress($billingAddress);
        
        $this->assertSame($billingAddress, $customer->getBillingAddress());
        $this->assertTrue($customer->hasAddress($billingAddress));
        
        $customer->setBillingAddress($this->getAddress());
        
        $this->assertFalse($customer->hasAddress($billingAddress));
    }
    
    public function testShippingAddress()
    {
        $customer = $this->getCustomer();
        $shippingAddress = $this->getAddress();
        
        $this->assertNull($customer->getShippingAddress());
        $this->assertNotContains($shippingAddress, $customer->getAddresses());
        
        $customer->setShippingAddress($shippingAddress);
        
        $this->assertSame($shippingAddress, $customer->getShippingAddress());
        $this->assertContains($shippingAddress, $customer->getAddresses());
    }    
            
    public function testAddAddress()
    {
        $customer = $this->getCustomer();
        $address = $this->getAddress();
        
        $this->assertNotContains($address, $customer->getAddresses());        
        $customer->addAddress($address);
        $this->assertContains($address, $customer->getAddresses());
    }   
    
    public function testRemoveAddress()
    {
        $customer = $this->getCustomer();
        $address = $this->getAddress();
        $customer->addAddress($address);
        
        $this->assertContains($address, $customer->getAddresses());
        $customer->removeAddress($address);
        $this->assertNotContains($address, $customer->getAddresses());
    } 
    
    public function testHasAddress()
    {
        $customer = $this->getCustomer();
        $address = $this->getAddress();
        
        $this->assertFalse($customer->hasAddress($address));
        $customer->addAddress($address);
        $this->assertTrue($customer->hasAddress($address));
    }     
            
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $customer = $this->getCustomer();
        
        $this->assertEquals($default, $customer->$getter());
        $customer->$setter($value);
        $this->assertEquals($value, $customer->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),            
        );
    }     
    
    /**
     * @return CustomerInterface
     */
    protected function getCustomer()
    {
        return $this->getMockForAbstractClass('IR\Bundle\CustomerBundle\Model\Customer');
    }   
    
    /**
     * @return AddressInterface
     */
    protected function getAddress()
    {       
        return $this->getMockForAbstractClass('IR\Bundle\AddressBundle\Model\AddressInterface');
    }       
}
