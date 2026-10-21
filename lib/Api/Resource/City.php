<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Exception;

class City extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Update;

    const OBJECT_NAME = 'city';

    const PLURAL_NAME = 'cities';

    const RELATION_TO_CLASS = [
        'province' => Province::class,
    ];

    public static function retrieve(string|int $id, $headers = null)
    {
        throw new Exception\BadMethodCallException('Retrieving individual cities is not supported by the API.');
    }

    public function refresh()
    {
        throw new Exception\BadMethodCallException('Refreshing individual cities is not supported by the API.');
    }
}
