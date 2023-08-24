<?php

namespace Salesteer\Api\Resource;

use Salesteer\Salesteer;
use Salesteer\SalesteerObject;
use Salesteer\Exception as Exception;
use Salesteer\SalesteerClient;

abstract class ApiPaginateResource extends SalesteerObject
{
    public $resourceClass = null;

    public static function parse(
        $responseClass,
        $values,
        SalesteerClient $client = null,
        ?array $headers = null,
    )
    {
        $obj = new static($values['id'] ?? null, $client, $headers);
        $obj->resourceClass = $responseClass;
        $obj->refreshFrom($values);

        return $obj;
    }

    public function getRelationClass($key){
        if($key === 'data'){
            return $this->resourceClass;
        }
        return null;
    }
}
