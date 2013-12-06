<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\Doctrine;

use IR\Bundle\CustomerBundle\Model\Address;
use IR\Bundle\CustomerBundle\Doctrine\AddressManager;

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

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;
    
    
    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }  
                
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
                
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::ADDRESS_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::ADDRESS_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::ADDRESS_CLASS));        
        
        $this->addressManager = new AddressManager($this->objectManager, static::ADDRESS_CLASS);
    }    
    
    public function testUpdateAddress()
    {
        $address = $this->getAddress();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($address));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->addressManager->updateAddress($address);
    }   

    public function testDeleteAddress()
    {
        $address = $this->getAddress();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($address));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->addressManager->deleteAddress($address);
    }     
    
    public function testFindAddressBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->addressManager->findAddressBy($criteria);
    }    
    
    public function testGetClass()
    {
        $this->assertEquals(static::ADDRESS_CLASS, $this->addressManager->getClass());
    }

    /**
     * @return Address
     */
    protected function getAddress()
    {
        $class = static::ADDRESS_CLASS;

        return new $class();
    }    
}