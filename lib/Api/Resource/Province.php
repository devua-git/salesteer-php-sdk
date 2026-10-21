<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Exception;

class Province extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Update;

    const OBJECT_NAME = 'province';

    const RELATION_TO_CLASS = [
        'state' => State::class,
    ];

    public static function retrieve(string|int $id, $headers = null)
    {
        throw new Exception\BadMethodCallException('Retrieving individual provinces is not supported by the API.');
    }

    public function refresh()
    {
        throw new Exception\BadMethodCallException('Refreshing individual provinces is not supported by the API.');
    }
}
