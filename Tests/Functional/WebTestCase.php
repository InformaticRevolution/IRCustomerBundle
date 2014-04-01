<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\Functional;

use Nelmio\Alice\Fixtures;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\BrowserKit\Client;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

/**
 * Web Test Case.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class WebTestCase extends BaseWebTestCase
{
    /**
     * @var Client 
     */
    protected $client;
    
    
    /**
     * Creates a fresh database.
     */
    protected final function importDatabaseSchema()
    {        
        $em = $this->getEntityManager();
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        
        if (!empty($metadata)) {
            $schemaTool = new SchemaTool($em);
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }        
    }     

    /**
     * Loads test fixtures from given file.
     * 
     * @param string $filename
     * 
     * @return array
     */    
    protected function loadFixtures($filename)
    {
        return Fixtures::load(sprintf(__DIR__.'/Fixtures/%s.yml', $filename), $this->getEntityManager(), array('providers' => array($this)));
    }     

    /**
     * Returns doctrine orm entity manager.
     * 
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {        
        return static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }    
    
    /**
      * Generates a CSRF token.
      * 
      * @param string $intention
      * 
      * @return string
      */
    protected function generateCsrfToken($intention)
    {
        return $this->client->getContainer()->get('form.csrf_provider')->generateCsrfToken($intention);
    }      

    /**
     * Asserts the response status code.
     * 
     * @param integer $statusCode
     */
    protected function assertResponseStatusCode($statusCode)
    {
        $this->assertEquals($statusCode, $this->client->getResponse()->getStatusCode());
    }     
    
    /**
     * Asserts the current uri.
     * 
     * @param string $uri
     */
    protected function assertCurrentUri($uri)
    {
        $this->assertStringEndsWith($uri, $this->client->getHistory()->current()->getUri());
    }    
        
    protected function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove(sys_get_temp_dir().'/IRCustomerBundle/');
    }     
}
