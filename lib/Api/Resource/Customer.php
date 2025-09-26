<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Customer extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const OBJECT_NAME = 'customer';

    const RELATION_TO_CLASS = [
        'legal_office' => Place::class,
    ];
}
