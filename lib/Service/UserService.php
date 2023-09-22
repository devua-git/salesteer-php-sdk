<?php

namespace Salesteer\Service;

use Salesteer\SalesteerObject;
use Salesteer\Api as Api;
use Salesteer\Exception as Exception;

class UserService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, array $params = null, array $headers = []) : Api\Resource\User
    {
        $url = $this->buildPath('%s', $id, Api\Resource\User::classUrl());
        $res = $this->request('get', $url, $params, $headers, Api\Resource\User::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(array $params = null, array $headers = []) : SalesteerObject
    {
        //TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\User::classUrl(true), $params, $headers, Api\Resource\User::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(array $params = null, array $headers = []) : Api\Resource\User
    {
        $res = $this->request('post', Api\Resource\User::classUrl(), $params, $headers, Api\Resource\User::class);
        return $res;
    }
}
