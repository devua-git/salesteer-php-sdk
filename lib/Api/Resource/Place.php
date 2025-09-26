<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Contract as ApiContract;
use Salesteer\Api\Operation as ApiOperation;

class Place extends ApiResource
{
    use ApiContract\HasContacts;
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const OBJECT_NAME = 'place';

    const RELATION_TO_CLASS = [
        'contacts' => Contact::class,
    ];
}
