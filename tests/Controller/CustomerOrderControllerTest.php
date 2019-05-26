<?php
// tests/Controller/CustomerOrderControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerOrderControllerTest extends WebTestCase
{
    public function testCustomerOrderSummaryApi()
    {
    	
        $client = static::createClient();
		$client->request(
	        'POST',
	        '/api/customer/orders/summary',
	        [],
	        [],
	        [
	        	'CONTENT_TYPE' => 'application/json',
	        	'HTTP_X-AUTH-TOKEN'=>'0587365e7ec362d52ffb-1558893137',
	        ],
	        '{
				  "productsIdsArr":{
				            "0":{"productId":2,"quantity":2},
				            "1":{"productId":3,"quantity":2},
				            "2":{"productId":4,"quantity":2}
				  }
				}'
	    );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCustomerOrderSaveApi()
    {
    	
        $client = static::createClient();
		$client->request(
	        'POST',
	        '/api/customer/orders/summary',
	        [],
	        [],
	        [
	        	'CONTENT_TYPE' => 'application/json',
	        	'HTTP_X-AUTH-TOKEN'=>'0587365e7ec362d52ffb-1558893137',
	        ],
	        '{
				"fullName":"John Smith",
				"email":"john@app.com",
				"contactNumber":"+92787887878",
				"postalCode":"46000",
				"shippingAddress":"House#xyz, Street abc",
				"city":"City name",
				"country":"Pakistan",
				"customerNotes":"This order placed from Unit testing...",
				  "productsIdsArr":{
				            "0":{"productId":2,"quantity":2},
				            "1":{"productId":3,"quantity":2},
				            "2":{"productId":4,"quantity":2}
				  }
				}'
	    );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}