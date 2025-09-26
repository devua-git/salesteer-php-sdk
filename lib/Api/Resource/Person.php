<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Contract as ApiContract;
use Salesteer\Api\Operation as ApiOperation;

class Person extends ApiResource
{
    use ApiContract\HasContacts;
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const OBJECT_NAME = 'person';

    const PLURAL_NAME = 'people';

    const RELATION_TO_CLASS = [
        'legal_office' => Place::class,
        'contacts' => Contact::class,
    ];
}
