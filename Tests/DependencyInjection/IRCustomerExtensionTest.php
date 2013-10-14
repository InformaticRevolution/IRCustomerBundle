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
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testCustomerLoadThrowsExceptionUnlessAddressModelClassSet()
    {
        $loader = new IRCustomerExtension();
        $config = $this->getFullConfig();
        unset($config['address']['address_class']);
        $loader->load(array($config), new ContainerBuilder());
    }    
    
    public function testCustomerLoadAddressClassesWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertNotHasDefinition('ir_customer.manager.address');
        $this->assertNotHasDefinition('ir_customer.form.address');
    }    
    
    public function testCustomerLoadAddressClasses()
    {
        $this->createFullConfiguration();

        $this->assertAlias('ir_customer.manager.address.default', 'ir_customer.manager.address');
        $this->assertParameter('acme_customer_address', 'ir_customer.form.type.address');
        $this->assertParameter('acme_customer_address_form', 'ir_customer.form.name.address');
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
        $this->configuration = new ContainerBuilder();
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
        $yaml = <<<EOF
db_driver: orm
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    } 
    
    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $yaml = <<<EOF
db_driver: orm
address:
    address_class: Acme\CustomerBundle\Entity\Address
    form:
        type: acme_customer_address
        name: acme_customer_address_form 
        validation_groups: [acme_address]
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }     
    
    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
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
