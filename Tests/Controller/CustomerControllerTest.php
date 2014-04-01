<?php

/*
 * This file is part of the IRCustomerBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\CustomerBundle\Tests\Controller;

use IR\Bundle\CustomerBundle\Tests\Functional\WebTestCase;

/**
 * Customer Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CustomerControllerTest extends WebTestCase
{   
    const FORM_INTENTION = 'profile';
    
    
    protected function setUp()
    {
        $this->client = static::createClient();
        $this->importDatabaseSchema();
        $this->loadFixtures('customer');
    }    
    
    public function testListAction()
    {   
        $crawler = $this->client->request('GET', '/admin/customers/');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('tbody tr'));
    }  

    public function testShowAction()
    {
        $this->client->request('GET', '/admin/customers/1');
        
        $this->assertResponseStatusCode(200);
    }    
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/admin/customers/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/admin/customers/new', array(
            'ir_customer_form' => array (
                'email' => 'test@example.com',
                'plainPassword' => '123456',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            )
        )); 
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/customers/4');
    }     
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/admin/customers/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }    
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/admin/customers/1/edit', array(
            'ir_customer_form' => array (
                'email' => 'test@example.com',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            )
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/customers/1');
        $this->assertRegExp('~test@example.com~', $crawler->filter('tbody')->text());
    }     
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/customers/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertCurrentUri('/admin/customers/');
        $this->assertCount(2, $crawler->filter('tbody tr'));
    }      
    
    public function testNotFoundHttpWhenCustomerNotExist()
    {
        $this->client->request('GET', '/admin/customers/foo');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/admin/customers/foo/edit');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/admin/customers/foo/delete');
        $this->assertResponseStatusCode(404);        
    }   
}
