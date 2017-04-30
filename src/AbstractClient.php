<?php

namespace Snugzone;

use Http\Message\MessageFactory;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Client\HttpClient;

abstract class AbstractClient
{
    /**
     * @var HttpClient
     */
    private $client;
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @param HttpClient          $client
     * @param MessageFactory|null $factory
     */
    public function __construct(HttpClient $client, MessageFactory $factory = null)
    {
        $this->client = $client;
        $this->messageFactory = $factory;
    }

    /**
     * Returns the HTTP adapter.
     *
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        return $this->client;
    }

    /**
     * @return MessageFactory
     */
    protected function getMessageFactory()
    {
        if ($this->messageFactory === null) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }

        return $this->messageFactory;
    }

    /**
     * @param HttpClient $client
     *
     * @return AbstractClient
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param MessageFactory $messageFactory
     *
     * @return AbstractClient
     */
    public function setMessageFactory(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;

        return $this;
    }

    /**
     * @param String $content
     *
     * @return \StdClass
     */
    protected function decodeJson(String $content)
    {
        $json = json_decode($content);

//      throw new \Exception('API response is not a valid JSON string: ' . $content);
        return $json;
    }

    /**
     * @param array $parts
     *
     * @return String
     */
    protected function buildUrl(array $parts)
    {
        return implode('/', $parts);
    }
}
