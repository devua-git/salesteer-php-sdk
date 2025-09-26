<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class PaymentDeadline extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const OBJECT_NAME = 'payment-deadline';

    const RELATION_TO_CLASS = [];

    const TYPE_ACTIVE = 'active';

    const TYPE_PASSIVE = 'passive';

    const AVAILABLE_TYPES = [
        self::TYPE_ACTIVE,
        self::TYPE_PASSIVE,
    ];
}
