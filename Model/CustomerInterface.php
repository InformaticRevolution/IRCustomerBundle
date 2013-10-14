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

use FOS\UserBundle\Model\UserInterface;

/**
 * Customer Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface CustomerInterface extends UserInterface
{    
    /**
     * Returns the title.
     *
     * @return string 
     */
    public function getTitle(); 
            
    /**
     * Sets the title.
     *
     * @param string $title
     */
    public function setTitle($title);    
    
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
     * Returns the creation time.
     *
     * @return \Datetime
     */
    public function getCreatedAt();   
    
    /**
     * Sets the creation time.
     * 
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt);    
    
    /**
     * Returns the last update time.
     *
     * @return \Datetime
     */
    public function getUpdatedAt();  
    
    /**
     * Sets the last update time.
     * 
     * @param \Datetime|null $updatedAt
     */
    public function setUpdatedAt(\Datetime $updatedAt = null);    
}