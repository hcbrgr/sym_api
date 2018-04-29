<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }
    /**
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
        $this->assertContains('lates', $response->getContent());
        $this->assertContains('present', $response->getContent());
    }
}