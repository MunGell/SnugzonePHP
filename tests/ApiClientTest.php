<?php


use GuzzleHttp\Psr7\Response;
use Snugzone\ApiClient;
use Snugzone\Tests\TestCase;

class ApiClientTest extends TestCase
{
    /**
     * @test
     * @covers Snugzone\ApiClient::login
     */
    public function loginSuccessful()
    {
        $client = $this->getMockClient(function ($request) {
            return new Response(200, [],
                '{"customer_id":"100","service_type":"1","error":"","error_url":"","permanent_meter_id":100,"has_remote_control":false,"is_prepay":true}');
        });

        $apiClient = new ApiClient($client);
        $this->assertTrue($apiClient->login('', '', ''));
    }

    /**
     * @test
     * @covers Snugzone\ApiClient::login
     */
    public function loginBrokenJson()
    {
        $client = $this->getMockClient(function ($request) {
            return new Response(200, [], '{true}');
        });

        $apiClient = new ApiClient($client);
        $this->assertFalse($apiClient->login('', '', ''));
    }

    /**
     * @test
     * @covers Snugzone\ApiClient::login
     */
    public function loginErrorReturned()
    {
        $client = $this->getMockClient(function ($request) {
            return new Response(200, [], '{"error": "Some error happened"}');
        });

        $apiClient = new ApiClient($client);
        $this->assertFalse($apiClient->login('', '', ''));
    }

    /**
     * @test
     * @covers Snugzone\ApiClient::login
     */
    public function loginServerError()
    {
        $client = $this->getMockClient(function ($request) {
            return new Response(404, [], '{"error": ""}');
        });

        $apiClient = new ApiClient($client);
        $this->assertFalse($apiClient->login('', '', ''));
    }
}
