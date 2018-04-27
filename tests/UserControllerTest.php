<?php

namespace App\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 * @package App\Tests
 */
class UserControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function loginTestFail()
    {
        $client = static::createClient();

        $data = [
            'Email' => 'lala@lala.com',
            'Password' => 'password'
        ];

        $client->request('POST', '/api/login', [], [], ['CONTENT_TYPE' => 'application/json'], '{"Email":"lala@lala.com", "Password":"password"}'
        );

        $this->assertEquals(422,$client->getResponse()->getStatusCode());
    }
}