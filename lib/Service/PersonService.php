<?php

namespace Salesteer\Service;

use Salesteer\Api;
use Salesteer\Exception;
use Salesteer\SalesteerObject;

class PersonService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, ?array $params = null, array $headers = []): Api\Resource\Person
    {
        $url = $this->buildPath('%s', $id, Api\Resource\Person::classUrl());
        $res = $this->request('get', $url, $params, $headers, Api\Resource\Person::class);

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(?array $params = null, array $headers = []): SalesteerObject
    {
        // TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\Person::classUrl(true), $params, $headers, Api\Resource\Person::class);

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(?array $params = null, array $headers = []): Api\Resource\Person
    {
        $res = $this->request('post', Api\Resource\Person::classUrl(), $params, $headers, Api\Resource\Person::class);

        return $res;
    }
}
