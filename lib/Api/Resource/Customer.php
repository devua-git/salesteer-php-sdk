<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Customer extends ApiResource
{
    use ApiOperation\Retrieve;

    const OBJECT_NAME = 'customer';
}
