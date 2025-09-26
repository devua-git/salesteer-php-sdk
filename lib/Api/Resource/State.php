<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class State extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const OBJECT_NAME = 'state';

    const RELATION_TO_CLASS = [
        'country' => Country::class,
    ];
}
