<?php

namespace Salesteer\Api\Contract;

use Salesteer\Api\Resource as ApiResource;

/**
 * @property ?array<ApiResource\Users> $assignees
 */
trait HasAssignees
{
    /**
     * @throws Exception\ApiErrorException
     */
    public function assignUsers($usersIds = [])
    {
        $entityName = static::OBJECT_NAME;

        $url = "assignTo/$entityName/{$this->id}";
        $this->request('post', $url, [
            "users" => $usersIds,
        ]);
    }

    /**
     * @throws Exception\ApiErrorException
     */
    public function unassignUsers($usersIds = [])
    {
        $entityName = static::OBJECT_NAME;

        $url = "unassignFrom/$entityName/{$this->id}";
        $this->request('post', $url, [
            "users" => $usersIds,
        ]);
    }
}