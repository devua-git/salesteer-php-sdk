<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Customer extends ApiResource
{
    use ApiOperation\Retrieve;
    use ApiOperation\Update;
    use ApiOperation\Drop;

    const OBJECT_NAME = 'customer';
}
