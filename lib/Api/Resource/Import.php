<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class Import extends ApiResource
{
    use ApiOperation\Drop;
    use ApiOperation\Retrieve;
    use ApiOperation\Update;

    const IS_API_PLURAL = true;

    const OBJECT_NAME = 'import';

    const RELATION_TO_CLASS = [];

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
