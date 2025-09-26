<?php

namespace Salesteer\Service;

use Salesteer\Api;
use Salesteer\Exception;
use Salesteer\SalesteerObject;

class CityService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(?array $params = null, array $headers = []): SalesteerObject
    {
        // TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\City::classUrl(true), $params, $headers, Api\Resource\City::class);

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(?array $params = null, array $headers = []): Api\Resource\City
    {
        $res = $this->request('post', Api\Resource\City::classUrl(), $params, $headers, Api\Resource\City::class);

        return $res;
    }
}
