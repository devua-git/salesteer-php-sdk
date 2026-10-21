<?php

namespace Salesteer\Api\Resource;

use Salesteer\Exception;

class PipelineEntityStep extends ApiResource
{
    const OBJECT_NAME = 'pipeline';

    public static function retrieve(string|int $id, $headers = null)
    {
        throw new Exception\BadMethodCallException('Retrieving a pipeline entity step by ID is not supported by the API.');
    }

    public function refresh()
    {
        throw new Exception\BadMethodCallException('Refreshing a pipeline entity step by ID is not supported by the API.');
    }
}
