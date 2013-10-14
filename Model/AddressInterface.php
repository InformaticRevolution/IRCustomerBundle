<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Model;

/**
 * Address Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface AddressInterface
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();    

    /**
     * Returns the customer.
     *
     * @return CustomerInterface 
     */
    public function getCustomer(); 
            
    /**
     * Sets the customer.
     *
     * @param CustomerInterface $customer
     */
    public function setCustomer(CustomerInterface $customer = null);    
    
    /**
     * Returns the first name.
     *
     * @return string 
     */
    public function getFirstName(); 
            
    /**
     * Sets the first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName);
    
    /**
     * Returns the last name.
     *
     * @return string 
     */
    public function getLastName();  
    
    /**
     * Sets the last name.
     *
     * @param string $lastName
     */
    public function setLastName($lastName);     
    
    /**
     * Returns the full name.
     * 
     * @return string
     */       
    public function getFullName();
    
    /**
     * Returns the street.
     *
     * @return string
     */
    public function getStreet();

    /**
     * Sets the street.
     *
     * @param string $street
     */
    public function setStreet($street);  
    
    /**
     * Returns the postal code.
     *
     * @return string
     */
    public function getPostalCode();

    /**
     * Sets the postal code.
     *
     * @param string $postalCode
     */
    public function setPostalCode($postalCode);  
        
    /**
     * Returns the city.
     *
     * @return string
     */
    public function getCity();

    /**
     * Sets the city.
     *
     * @param string $city
     */
    public function setCity($city);  

    /**
     * Returns the country.
     *
     * @return string
     */
    public function getCountry();

    /**
     * Sets the country.
     *
     * @param string $country
     */
    public function setCountry($country);      
}