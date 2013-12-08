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
 * Abstract Address implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Address implements AddressInterface
{  
    /**
     * @var mixed
     */
    protected $id;    

    /**
     * @var CustomerInterface
     */
    protected $customer;    

    /**
     * @var string
     */
    protected $title;    
    
    /**
     * @var string
     */
    protected $firstName;
    
    /**
     * @var string
     */
    protected $lastName;    
    
    /**
     * @var string
     */
    protected $street;
     
    /**
     * @var string
     */
    protected $postalCode; 
      
    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $country;  
    
    /**
     * @var string
     */
    protected $phone;    
    
    
    /**
     * {@inheritdoc}
     */  
    public function getId()
    {
        return $this->id;
    } 
    
    /**
     * {@inheritdoc}
     */  
    public function getCustomer()
    {
        return $this->customer;
    }
            
    /**
     * {@inheritdoc}
     */  
    public function setCustomer(CustomerInterface $customer = null)
    {
        $this->customer = $customer;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }
            
    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }     
    
    /**
     * {@inheritdoc}
     */   
    public function getFirstName()
    {
        return $this->firstName;
    }
        
    /**
     * {@inheritdoc}
     */   
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    } 
    
    /**
     * {@inheritdoc}
     */       
    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }      
    
    /**
     * {@inheritdoc}
     */
    public function getStreet()
    {
        return $this->street;
    }
            
    /**
     * {@inheritdoc}
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }    
    
    /**
     * {@inheritdoc}
     */   
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }
        
    /**
     * {@inheritdoc}
     */   
    public function getCity()
    {
        return $this->city;
    }
        
    /**
     * {@inheritdoc}
     */   
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * {@inheritdoc}
     */   
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function setCountry($country)
    {
        $this->country = $country;
    }    
    
    /**
     * {@inheritdoc}
     */   
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * {@inheritdoc}
     */   
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }    
}