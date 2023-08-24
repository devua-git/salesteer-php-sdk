<?php

namespace Salesteer\Service;

use Salesteer\Exception as Exception;
use Salesteer\SalesteerClientInterface;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    public function __construct(protected SalesteerClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient() : SalesteerClientInterface
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $headers, $responseClass)
    {
        return $this->getClient()->request($method, $path, $responseClass, $params, $headers);
    }

    protected function buildPath($basePath, $ids, $classPath = '')
    {
        if(!is_array($ids)){
            $ids = [$ids];
        }

        foreach ($ids as $id) {
            if (null === $id || '' === trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';

                throw new Exception\InvalidArgumentException($msg);
            }
        }

        $builtPath = sprintf($basePath, ...array_map('urlencode', $ids));

        return "$classPath/$builtPath";
    }
}
