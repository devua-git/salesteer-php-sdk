<?php

namespace Salesteer\Service;

use Salesteer\Exception as Exception;
use Salesteer\SalesteerClientInterface;

/**
 * Abstract base class for all service factories used to expose service
 * instances through {@link \Salesteer\SalesteerClient}.
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for
 *    a given service is used.
 */
abstract class AbstractServiceFactory
{
    private SalesteerClientInterface $client;

    /** @var array<string, AbstractService|AbstractServiceFactory> */
    private array $services;

    public function __construct(SalesteerClientInterface $client)
    {
        $this->client = $client;
        $this->services = [];
    }

    abstract protected function getServiceClass(string $name) : string;

    public function __get(string $name) : AbstractService|AbstractServiceFactory
    {
        return $this->getService($name);
    }

    public function getService(string $name) : AbstractService|AbstractServiceFactory
    {
        $serviceClass = $this->getServiceClass($name);
        if (null !== $serviceClass) {
            if (!array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        throw new Exception\UnexpectedValueException('Undefined property: ' . static::class . '::$' . $name);
    }
}
