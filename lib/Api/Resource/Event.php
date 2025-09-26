<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Event extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const RELATION_TO_CLASS = [];

    const OBJECT_NAME = 'event';

    const PLURAL_NAME = 'events';
}
