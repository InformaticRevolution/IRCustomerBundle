<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use IR\Bundle\CustomerBundle\Model\AddressInterface;
use IR\Bundle\CustomerBundle\Manager\AddressManager as AbstractAddressManager;

/**
 * Doctrine Address Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressManager extends AbstractAddressManager
{        
    /**
     * @var ObjectRepository
     */          
    protected $objectManager;
    
    /**
     * @var ObjectRepository
     */           
    protected $repository;    

    /**
     * @var string
     */           
    protected $class;
        
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {                   
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();       
    }    

    /**
     * Updates an address.
     *
     * @param AddressInterface $address
     * @param Boolean          $andFlush Whether to flush the changes (default true)
     */    
    public function updateAddress(AddressInterface $address, $andFlush = true)
    { 
        $this->objectManager->persist($address);
   
        if ($andFlush) {
            $this->objectManager->flush();
        }        
    }    

    /**
     * {@inheritDoc}
     */     
    public function deleteAddress(AddressInterface $address)
    {
        $this->objectManager->remove($address);
        $this->objectManager->flush();      
    }         
    
    /**
     * {@inheritDoc}
     */
    public function findAddressBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }         
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }      
}
