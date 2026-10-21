<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Exception;

class State extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Update;

    const OBJECT_NAME = 'state';

    const RELATION_TO_CLASS = [
        'country' => Country::class,
    ];

    public static function retrieve(string|int $id, $headers = null)
    {
        throw new Exception\BadMethodCallException('Retrieving individual states is not supported by the API.');
    }

    public function refresh()
    {
        throw new Exception\BadMethodCallException('Refreshing individual states is not supported by the API.');
    }
}
