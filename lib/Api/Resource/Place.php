<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Api\Contract as ApiContract;

class Place extends ApiResource
{
    use ApiOperation\Retrieve;
    use ApiOperation\Update;
    use ApiOperation\Drop;

    use ApiContract\HasContacts;

    const OBJECT_NAME = 'place';

    const RELATION_TO_CLASS = [
        'contacts' => Contact::class,
    ];
}
