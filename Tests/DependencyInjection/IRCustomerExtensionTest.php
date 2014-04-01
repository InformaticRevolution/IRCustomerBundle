<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IR\Bundle\CustomerBundle\DependencyInjection\IRCustomerExtension;

/**
 * Customer Extension Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRCustomerExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** 
     * @var ContainerBuilder 
     */
    protected $configuration;
    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testCustomerLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new IRCustomerExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }   
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testCustomerLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new IRCustomerExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }   
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCustomerLoadThrowsExceptionUnlessIRAddressBundleIsRegistered()
    {
        $this->configuration = new ContainerBuilder();
        $this->configuration->setParameter('kernel.bundles', array());
        $loader = new IRCustomerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
    }       

    public function testDisableCustomer()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRCustomerExtension();
        $config = $this->getEmptyConfig();
        $config['customer'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_customer.form.customer');
    }    

    public function testCustomerLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('orm', 'ir_customer.db_driver');
    }    
    
    public function testCustomerLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'ir_customer.db_driver');
    }       
    
    public function testCustomerLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_customer', 'ir_customer.form.type.customer');
        $this->assertNotHasDefinition('ir_customer.form.type.address');
    }    
    
    public function testCustomerLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_customer', 'ir_customer.form.type.customer');
        $this->assertParameter('acme_customer_address', 'ir_customer.form.type.address');
    }  
    
    public function testCustomerLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_customer_form', 'ir_customer.form.name.customer');
        $this->assertNotHasDefinition('ir_customer.form.name.address');
    }

    public function testCustomerLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_customer_form', 'ir_customer.form.name.customer');
        $this->assertParameter('acme_customer_address_form', 'ir_customer.form.name.address');
    }     
    
    public function testCustomerLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('ir_customer.form.customer');
        $this->assertNotHasDefinition('ir_customer.form.address');
    }       
    
    public function testCustomerLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('ir_customer.form.customer');
        $this->assertHasDefinition('ir_customer.form.address');
    }     

    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRCustomerExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }    
    
    protected function createFullConfiguration()
    {
        // Simulates the registration of the IRAddressBundle in the AppKernel
        $bundles = array('IRAddressBundle' => 'IR\Bundle\AddressBundle\IRAddressBundle');
        
        $this->configuration = new ContainerBuilder();
        $this->configuration->setParameter('kernel.bundles', $bundles);
        $loader = new IRCustomerExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }  
    
    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $parser = new Parser();

        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/minimal_config.yml'));
    }     

    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $parser = new Parser();

        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/full_config.yml'));
    }    

    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }    
    
    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }    
    
    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }
    
    protected function tearDown()
    {
        unset($this->configuration);
    }    
}
