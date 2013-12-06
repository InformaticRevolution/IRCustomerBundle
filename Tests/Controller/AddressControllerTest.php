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
 * Address Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class AddressControllerTest extends WebTestCase
{   
    const FORM_INTENTION = 'address';

    
    protected function setUp()
    {             
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'test@example.com',
            'PHP_AUTH_PW'   => '123456',            
        ));    
     
        $this->importDatabaseSchema();
        $this->loadFixtures('address');
    }
        
    public function testListAction()
    {   
        $crawler = $this->client->request('GET', '/addresses/');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('li'));
    }
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/addresses/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    } 
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/addresses/new', array(
            'ir_customer_address_form' => array (
                'firstName' => 'Jackson',
                'lastName' => 'Parker',
                'street' => '439 Karley Loaf Suite',
                'postalCode' => '63110',
                'city' => 'Chicago',
                'country' => 'US',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/addresses/');
        $this->assertCount(4, $crawler->filter('li'));
    } 
     
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/addresses/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/addresses/1/edit', array(
            'ir_customer_address_form' => array (
                'firstName' => 'Foo',
                'lastName' => 'Bar',
                'street' => '439 Karley Loaf Suite',
                'postalCode' => '63110',
                'city' => 'Chicago',
                'country' => 'US',                
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            )
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/addresses/');
        $this->assertRegExp('~Foo Bar~', $crawler->filter('li')->text());
    }     
               
    public function testDeleteAction()
    {
        $this->client->request('GET', '/addresses/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertCurrentUri('/addresses/');
        $this->assertCount(2, $crawler->filter('li'));
    }    
    
    public function testAuthenticationIsRequired()
    {
        $this->client = static::createClient();
        
        $this->client->request('GET', '/addresses/');
        $this->assertResponseStatusCode(401);

        $this->client->request('GET', '/addresses/new');
        $this->assertResponseStatusCode(401); 
        
        $this->client->request('GET', '/addresses/1/edit');
        $this->assertResponseStatusCode(401);        
        
        $this->client->request('GET', '/addresses/1/delete');
        $this->assertResponseStatusCode(401);        
    }      
    
    public function testAccessDeniedWhenCustomerNotOwnAddress()
    {
        $this->client->request('GET', '/addresses/4/edit');
        $this->assertResponseStatusCode(403);
        
        $this->client->request('GET', '/addresses/4/delete');
        $this->assertResponseStatusCode(403);        
    }    
    
    public function testNotFoundHttpWhenAddressNotExist()
    {
        $this->client->request('GET', '/addresses/foo/edit');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/addresses/foo/delete');
        $this->assertResponseStatusCode(404);        
    }  
}
