<?php

namespace Salesteer\Api\Operation;

use Salesteer\Exception as Exception;

trait Retrieve
{
    /**
     * @throws Exception\ApiErrorException
     */
    public static function retrieve(string|int $id, $headers = null)
    {
        $instance = new static($id, $headers);
        $instance->refresh();

        return $instance;
    }
}
