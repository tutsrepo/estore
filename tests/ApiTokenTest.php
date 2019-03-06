<?php 

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTokenTest extends WebTestCase
{
    // Test for Retriving Token without passing username, password

    public function testApiToken_NoCredentials()
    {
        $client = static::createClient();
        $client->request(
            'POST', 
            '/api/login_check', 
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            '{}'
        );
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    // Test for Retriving Token with valid Credentials

    public function testApiToken_Valid_Credentials()
    {
        $client = static::createClient();
        $client->request(
            'POST', 
            '/api/login_check', 
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            '{"username":"user5", "password":"user5"}'
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }    
}    