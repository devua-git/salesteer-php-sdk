<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Province extends ApiResource
{
    use ApiOperation\Retrieve;
    use ApiOperation\Update;
    use ApiOperation\Drop;

    const OBJECT_NAME = 'province';

    const RELATION_TO_CLASS = [
        'state' => State::class,
    ];
}