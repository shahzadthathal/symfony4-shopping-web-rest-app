<?php
// tests/Controller/ProductControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductsListingApi()
    {
    	
        $client = static::createClient();
		$client->request(
	        'GET',
	        '/api/products',
	        [],
	        [],
	        [
	        	'HTTP_X-AUTH-TOKEN'=>'0587365e7ec362d52ffb-1558893137',
	        ]
	    );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



    /*public function testAddContent()
    {
        $client = static::createClient();
		$client->request(
	        'POST',
	        '/api/content',
	        [],
	        [],
	        [
	        	'CONTENT_TYPE' => 'application/json',
	            'HTTP_X-AUTH-TOKEN' => 'xyz',
	        ],
	        '{"title":"My title from unit test","description":"My description from unit test","content":"My content from unit test","email":"xyz@app.com"}'
	    );
		
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }*/
}