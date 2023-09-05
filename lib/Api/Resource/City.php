<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class City extends ApiResource
{
    use ApiOperation\Retrieve;
    use ApiOperation\Update;
    use ApiOperation\Drop;

    const OBJECT_NAME = 'city';
    const PLURAL_NAME = 'cities';

    const RELATION_TO_CLASS = [
        'province' => Province::class,
    ];
}