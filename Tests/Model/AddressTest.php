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

use IR\Bundle\CustomerBundle\Model\Address;

/**
 * Address Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $address = $this->getAddress();
        
        $this->assertEquals($default, $address->$getter());
        $address->$setter($value);
        $this->assertEquals($value, $address->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('Firstname', 'James', null),
            array('Lastname', 'Brown', null),
            array('street', '439 Karley Loaf Suite', null),
            array('postalCode', '63419', null),
            array('city', 'New York', null),
            array('country', 'US', null),
        );
    }     
    
    /**
     * @return Address
     */
    protected function getAddress()
    {
        return $this->getMockForAbstractClass('IR\Bundle\CustomerBundle\Model\Address');
    }         
}
