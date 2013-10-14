<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use IR\Bundle\CustomerBundle\DependencyInjection\Compiler\ValidationPass;

/**
 * This bundle provides simple architecture for customers management.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRCustomerBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $this->addRegisterMappingsPass($container);
        $container->addCompilerPass(new ValidationPass());
    }    
        
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'IR\Bundle\CustomerBundle\Model',
        );   
        
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('ir_customer.entity_manager')));     
    }
   
    /**
     * {@inheritdoc}
     */     
    public function getParent()
    {
        return 'FOSUserBundle';
    }     
}
