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

use IR\Bundle\CustomerBundle\Model\Titles;
use IR\Bundle\CustomerBundle\Model\Customer;
use IR\Bundle\CustomerBundle\Model\Address;

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
        $this->assertContains($billingAddress, $customer->getAddresses());
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
        $this->assertNull($address->getCustomer());
        
        $customer->addAddress($address);
        
        $this->assertContains($address, $customer->getAddresses());
        $this->assertSame($customer, $address->getCustomer());        
    }   
    
    public function testRemoveAddress()
    {
        $customer = $this->getCustomer();
        $address = $this->getAddress();
        $customer->addAddress($address);
        
        $this->assertContains($address, $customer->getAddresses());
        $this->assertSame($customer, $address->getCustomer());
        
        $customer->removeAddress($address);
        
        $this->assertNotContains($address, $customer->getAddresses());
        $this->assertNull($address->getCustomer());
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
            array('Title', Titles::MISTER, Titles::MRS), 
            array('Firstname', 'James', null),
            array('Lastname', 'Brown', null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),            
        );
    }     
    
    /**
     * @return Customer
     */
    protected function getCustomer()
    {
        return $this->getMockForAbstractClass('IR\Bundle\CustomerBundle\Model\Customer');
    }   
    
    /**
     * @return Address
     */
    protected function getAddress()
    {
        return $this->getMockForAbstractClass('IR\Bundle\CustomerBundle\Model\Address');
    }       
}
