<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

use Salesteer\Api as Api;
use Salesteer\Exception as Exception;
use Salesteer\SalesteerObject;
use Salesteer\Util as Util;

class CustomerService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, array $params = null, array $headers = []) : Api\Resource\Customer
    {
        $url = $this->buildPath('%s', $id, Api\Resource\Customer::classUrl());
        $res = $this->request('get', $url, $params, $headers);
        return Util\Util::convertTo($res, Api\Resource\Customer::class);
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(array $params = null, array $headers = []) : SalesteerObject
    {
        //TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\Customer::classUrl(true), $params, $headers);

        //TODO: DO SOMETHING ABOUT PAGINATION
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(array $params = null, array $headers = []) : Api\Resource\Customer
    {
        $res = $this->request('post', Api\Resource\Customer::classUrl(), $params, $headers);
        return Util\Util::convertTo($res, Api\Resource\Customer::class);
    }
}
