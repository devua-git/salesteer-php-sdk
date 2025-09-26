<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Province extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const OBJECT_NAME = 'province';

    const RELATION_TO_CLASS = [
        'state' => State::class,
    ];
}
