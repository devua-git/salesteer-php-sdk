<?php

namespace Salesteer\Service;

use Salesteer\Api;
use Salesteer\Exception;
use Salesteer\SalesteerObject;

class ProvinceService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(?array $params = null, array $headers = []): SalesteerObject
    {
        // TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\Province::classUrl(true), $params, $headers, Api\Resource\Province::class);

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(?array $params = null, array $headers = []): Api\Resource\Province
    {
        $res = $this->request('post', Api\Resource\Province::classUrl(), $params, $headers, Api\Resource\Province::class);

        return $res;
    }
}
