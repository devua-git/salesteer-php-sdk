<?php

declare(strict_types=1);

namespace Salesteer\HttpClient;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Http implements ClientInterface, RequestFactoryInterface
{
    protected ClientInterface $client;

    protected RequestFactoryInterface $requestFactory;

    private function __construct(
        ?ClientInterface $client = null,
        ?RequestFactoryInterface $requestFactory = null
    ) {
        $this->client = $client ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
    }

    private static $_instance = null;

    public static function instance(): self
    {
        if (self::$_instance === null) {
            self::$_instance = new static;
        }

        return self::$_instance;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }

    /**
     * @param  'delete'|'get'|'post'|'patch'|'put'  $method
     */
    public function createRequest($method, $uri): RequestInterface
    {
        return $this->requestFactory->createRequest((string) $method, $uri);
    }
}
