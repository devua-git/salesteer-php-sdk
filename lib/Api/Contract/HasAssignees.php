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
    public function syncAssignees($usersIds = [], $headers = null)
    {
        $entityName = static::OBJECT_NAME;

        $url = "/assignees/sync";
        $this->request('post', $url, [
            "user_ids" => $usersIds,
            "entity_name" => $entityName,
            "entity_id" => $this->id,
        ], $headers);
    }

    /**
     * @throws Exception\ApiErrorException
     */
    public function attachAssignees($usersIds = [], $headers = null)
    {
        $entityName = static::OBJECT_NAME;

        $url = "/assignees/attach";
        $this->request('post', $url, [
            "user_ids" => $usersIds,
            "entity_name" => $entityName,
            "entity_id" => $this->id,
        ], $headers);
    }

    /**
     * @throws Exception\ApiErrorException
     */
    public function detachAssignees($usersIds = [], $headers = null)
    {
        $entityName = static::OBJECT_NAME;

        $url = "/assignees/detach";
        $this->request('post', $url, [
            "user_ids" => $usersIds,
            "entity_name" => $entityName,
            "entity_id" => $this->id,
        ], $headers);
    }
}