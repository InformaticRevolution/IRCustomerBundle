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

use FOS\UserBundle\Model\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abstract Customer implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Customer extends User implements CustomerInterface, AddressableInterface
{
    /**
     * @var AddressInterface 
     */    
    protected $billingAddress;
    
    /**
     * @var AddressInterface 
     */
    protected $shippingAddress;    
    
    /**
     * @var Collection
     */
    protected $addresses;
    
    /**
     * @var \Datetime
     */
    protected $createdAt;

    /**
     * @var \Datetime
     */
    protected $updatedAt;    
        
    
    /**
     * Constructor.
     */            
    public function __construct()
    {
        parent::__construct();
        
        $this->addresses = new ArrayCollection();
    }      

    /**
     * {@inheritdoc}
     */       
    public function setEmail($email)
    {
        parent::setEmail($email);
        
        $this->setUsername($email);
    }      
    
    /**
     * {@inheritdoc}
     */  
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */  
    public function setBillingAddress(AddressInterface $billingAddress = null)
    {
        if (null !== $billingAddress && !$this->hasAddress($billingAddress)) {
            $this->addAddress($billingAddress);
        }
        
        $this->billingAddress = $billingAddress;
    }
    
    /**
     * {@inheritdoc}
     */  
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * {@inheritdoc}
     */  
    public function setShippingAddress(AddressInterface $shippingAddress = null)
    {
        if (null !== $shippingAddress && !$this->hasAddress($shippingAddress)) {
            $this->addAddress($shippingAddress);
        }
        
        $this->shippingAddress = $shippingAddress;        
    }
    
    /**
     * {@inheritdoc}
     */           
    public function getAddresses()
    {
        return $this->addresses;
    }    
    
    /**
     * {@inheritdoc}
     */     
    public function addAddress(AddressInterface $address)
    {
        if (!$this->hasAddress($address)) {
            $address->setCustomer($this);
            $this->addresses->add($address);
        }
    }    
    
    /**
     * {@inheritdoc}
     */       
    public function removeAddress(AddressInterface $address)
    {
        if ($this->addresses->removeElement($address)) {
            $address->setCustomer(null);
        }
    }    
    
    /**
     * {@inheritdoc}
     */     
    public function hasAddress(AddressInterface $address)
    {
        return $this->addresses->contains($address);
    }      
    
    /**
     * {@inheritdoc}
     */   
    public function getCreatedAt()
    {
        return $this->createdAt;
    }    

    /**
     * {@inheritdoc}
     */   
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;        
    }      
    
    /**
     * {@inheritdoc}
     */   
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    } 

    /**
     * {@inheritdoc}
     */   
    public function setUpdatedAt(\Datetime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;        
    }
}