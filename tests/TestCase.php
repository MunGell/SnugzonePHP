<?php

namespace Snugzone\Tests;

use Http\Client\HttpClient;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * @param \Closure|null $requestCallback
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockClient(\Closure $requestCallback = null)
    {
        $client = $this->getMockForAbstractClass(HttpClient::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturnCallback(function (RequestInterface $request) use ($requestCallback) {
                if (is_null($requestCallback)) {
                    return new Response(200, [], '');
                }

                $response = $requestCallback($request);
                if (!($response instanceof ResponseInterface)) {
                    $response = new Response(200, [], (string) $response);
                }

                return $response;
            });

        return $client;
    }
}
