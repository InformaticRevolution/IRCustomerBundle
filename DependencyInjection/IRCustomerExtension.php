<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;   
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * Customer Extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRCustomerExtension extends Extension implements PrependExtensionInterface
{    
    /**
     * {@inheritDoc}
     */    
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        
        if (!isset($bundles['FOSUserBundle'])) {
            return;
        }

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);
        
        $preconfig = array(
            'db_driver' => $config['db_driver'],
            'registration' => array(
                'form' => array (
                    'type' => 'ir_customer_registration',
                    'validation_groups' => array('CRegistration', 'Default'),
                )
            ),
            'profile' => array(
                'form' => array (
                    'type' => 'ir_customer_account',
                    'validation_groups' => array('Account', 'Default'),
                )
            )
        );
        
        $container->prependExtensionConfig('fos_user', $preconfig);                
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        foreach (array('account', 'listeners', 'registration', 'title') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }          
        
        $container->setParameter('ir_customer.db_driver', $config['db_driver']);
        
        if (!empty($config['customer'])) {
            $this->loadCustomer($config['customer'], $container, $loader);
        }        
        
        if (!empty($config['address'])) {
            $this->loadAddress($config['address'], $container, $loader, $config['db_driver']);
        }         
    }   
    
    private function loadCustomer(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('customer.xml');

        $container->setParameter('ir_customer.form.name.customer', $config['form']['name']);
        $container->setParameter('ir_customer.form.type.customer', $config['form']['type']); 
        $container->setParameter('ir_customer.form.validation_groups.customer', $config['form']['validation_groups']);
    }      

    private function loadAddress(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {
        $loader->load('address.xml');
        $loader->load(sprintf('driver/%s/address.xml', $dbDriver));

        $container->setParameter('ir_customer.model.address.class', $config['address_class']);
        $container->setParameter('ir_customer.form.name.address', $config['form']['name']);
        $container->setParameter('ir_customer.form.type.address', $config['form']['type']);
        $container->setParameter('ir_customer.form.validation_groups.address', $config['form']['validation_groups']);
        
        $container->setAlias('ir_customer.manager.address', $config['address_manager']);
    }     
}
