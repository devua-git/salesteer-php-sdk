<?php

namespace Salesteer\Service;

use Salesteer\Api\Resource\Import;

class ImportService extends AbstractService
{
    public function create(?array $params = null, array $headers = []): Import
    {
        $res = $this->request('post', Import::classUrl(), $params, $headers, Import::class);

        return $res;
    }
}
