<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{

    /**
     * @var null
     */
    private $client = null;

    /**
     *Set the client to the static method createClient
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test if the login method works by inserting json with the email and password
     *
     * @test
     */
    public function loginTest()
    {
        $this->client->request('POST', '/api/login', [], [], ['CONTENT_TYPE' => 'application/json'], '{"Email":"lala@lala.com", "Password":"password"}');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('token', $response->getContent());
    }

    /**
     * Test if the refresh token method works by inserting json with the current token
     *
     * @test
     */
    public function refreshTokenTest()
    {

        $this->client->request('POST', '/api/refreshToken', [], [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI1MDI1MTk0O30='
            ],
            '{"token": "YToxOntpOjE7aToxNTI1MDI1MTk0O30="}');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('token', $response->getContent());
    }

    /**
     * Test if the getLocation method works by send the current token in header
     *
     * @test
     */
    public function getLocationTest()
    {
        $this->client->request('GET', '/api/getLocation', [], [], ['HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI1MDI1MTk0O30=']);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('date', $response->getContent());
        $this->assertContains('location', $response->getContent());

    }

    /**
     * Test if the checkIn method works by inserting json with QRCode data, date, beaconCollectoin and current token
     *
     * @test
     */
    public function checkInDoneTest()
    {
        $this->client->request('POST', "/api/checkIn" ,[], [], [
            'HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI1MDI1MTk0O30=',
            'CONTENT_TYPE' => 'application/json'
        ],
            '{
                        "QRCodeData" : "Salle7_20180429_131140",
                        "date": "2018-04-29 17:05:00",
                        "beaconCollection":
                        [
                            65535,
                            381, 
                            4294902141
                        ],
	                       "Token": "YToxOntpOjE7aToxNTI1MDI1MTk0O30="
                    }'
        );
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('OK', $response->getContent());
    }

    /**
     * Test if the checkIn method doesn't works by inserting the same thing that the previous method test.
     * This method check if an user can flash a second time the QRCode without to be late
     *
     * @test
     */
    public function checkInFailTest()
    {
        $this->client->request('POST', "/api/checkIn" ,[], [], [
            'HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI1MDI1MTk0O30=',
            'CONTENT_TYPE' => 'application/json'
        ],
            '{
                        "QRCodeData" : "Salle7_20180429_131140",
                        "date": "2018-04-29 17:06:00",
                        "beaconCollection":
                        [
                            65535,
                            381, 
                            4294902141
                        ],
	                       "Token": "YToxOntpOjE7aToxNTI1MDI1MTk0O30="
                    }'
        );
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('error', $response->getContent());
    }

    /**
     * Test if the report method works and send the goog key
     *
     * @test
     */
    public function reportTest()
    {
        $this->client->request('GET', "/api/report", [], [], [
                'HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI1MDI1MTk0O30=',
                'CONTENT_TYPE' => 'application/json'
            ]
        );
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('absences', $response->getContent());
        $this->assertContains('delays', $response->getContent());
        $this->assertContains('presents', $response->getContent());
    }
}