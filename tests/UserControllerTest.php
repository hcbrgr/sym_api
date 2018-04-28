<?php

namespace App\Tests;

use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }
    /**
     * @test
     */
   /* public function loginTest()
    {
        $this->client->request('POST', '/api/login', [], [], ['CONTENT_TYPE' => 'application/json'], '{"Email":"lala@lala.com", "Password":"password"}');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    /*public function refreshToken()
    {
        $client = static::createClient();
        $client->request('POST', '/api/refreshToken', [], [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI0OTQyMTkwO30='
            ],
            '{"token": "YToxOntpOjE7aToxNTI0OTQyMTkwO30="}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    /*public function getLocation()
    {
        $this->client->request('GET', '/api/getLocation', [], [], ['HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI0OTQ3MzA3O30=']);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }*/

    /**
     * @test
     */
    /*public function getQRcode()
    {
        $client = static::createClient();
        $client->request('POST', '/getQRCode', [], ['location' => 1], [], ['HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI0OTQ0MDYwO30=']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/

    /**
     * @test
     */
    public function checkIn()
    {
        $client = static::createClient();
        $client->request('POST', "/api/checkIn" ,[], [], [
            'HTTP_X-AUTH-TOKEN' => 'YToxOntpOjE7aToxNTI0OTQ4NTM0O30=',
            'CONTENT_TYPE' => 'application/json'
        ],
            '{
                        "QRCodeData" : "test",
                        "date": "2018-04-29 00:00:00",
                        "beaconCollection":
                        [
                            65535,
                            381, 
                            4294902141
                        ],
	                       "Token": "YToxOntpOjE7aToxNTI0OTQ4NTM0O30="
                    }'
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}