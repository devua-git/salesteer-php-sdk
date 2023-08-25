<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Api\Contract as ApiContract;

class Person extends ApiResource
{
    use ApiOperation\Retrieve;
    use ApiOperation\Update;
    use ApiOperation\Drop;

    use ApiContract\HasContacts;

    const RELATION_TO_CLASS = [
        'legal_office' => Place::class,
        'contacts' => Contact::class,
    ];

    const OBJECT_NAME = 'person';
    const PLURAL_NAME = 'people';
}
