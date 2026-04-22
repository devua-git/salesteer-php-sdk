<?php

namespace Salesteer\Api\Resource;

class Comment extends ApiResource
{
    const OBJECT_NAME = 'comment';

    const RELATION_TO_CLASS = [
        'user' => User::class,
    ];
}
