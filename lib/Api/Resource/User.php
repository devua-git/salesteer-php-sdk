<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class User extends ApiResource
{
    use ApiOperation\Retrieve;

    const OBJECT_NAME = 'user';

    public function issueToken()
    {
        $url = $this->instanceUrl() . '/token';
        return $this->request('get', $url, [], null, User::class);
    }
}
