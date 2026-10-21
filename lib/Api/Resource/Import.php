<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Exception;

class Import extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;

    const IS_API_PLURAL = true;

    const OBJECT_NAME = 'import';

    const RELATION_TO_CLASS = [];

    public function save($headers = null)
    {
        throw new Exception\BadMethodCallException('Updating imports is not supported by the API. Use saveMappings() to update mappings.');
    }

    public function saveMappings(array $params, ?array $headers = null)
    {
        $url = $this->instanceUrl().'/mappings';
        $this->request('patch', $url, $params, $headers);

        return $this;
    }

    public function start(?array $headers = null)
    {
        $url = $this->instanceUrl().'/start';
        $this->request('post', $url, [], $headers);

        return $this;
    }
}
