<?php

namespace Salesteer\Service;

use Salesteer\Api\Resource\Comment;
use Salesteer\Exception;
use Salesteer\SalesteerObject;

class CommentService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(int $entityId, string $entityName, ?string $cursor = null, array $headers = []): SalesteerObject
    {
        $res = $this->request(
            'get',
            Comment::classUrl(true),
            [
                'filters' => [
                    'commentable_type' => [
                        'operator' => 'eq',
                        'value' => $entityName,
                    ],
                    'commentable_id' => [
                        'operator' => 'eq',
                        'value' => $entityId,
                    ],
                ],
                'format' => 'cursor',
                'cursor' => $cursor ?? '',
            ],
            $headers,
            Comment::class
        );

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(int $entityId, string $entityName, string $text, array $headers = []): Comment
    {
        $res = $this->request(
            'post',
            Comment::classUrl(),
            [
                'text' => $text,
                'commentable_id' => $entityId,
                'commentable_type' => $entityName,
            ],
            $headers,
            Comment::class
        );

        return $res;
    }
}
