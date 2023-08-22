<?php

namespace Salesteer\Service;

use Salesteer\Exception as Exception;
use Salesteer\SalesteerClientInterface;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    protected SalesteerClientInterface $client;

    public function __construct(SalesteerClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient() : SalesteerClientInterface
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $headers)
    {
        return $this->getClient()->request($method, $path, $params, $headers);
    }

    protected function buildPath($basePath, ...$ids)
    {
        foreach ($ids as $id) {
            if (null === $id || '' === trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';

                throw new Exception\InvalidArgumentException($msg);
            }
        }

        return sprintf($basePath, ...array_map('urlencode', $ids));
    }
}
