<?php

namespace Salesteer\Util;

use Salesteer\Api\Resource as Resource;

class ObjectTypes
{
    const mapping = [
        Resource\Customer::OBJECT_NAME => Resource\Customer::class,
    ];
}
