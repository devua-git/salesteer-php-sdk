<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

use Salesteer\Api as Api;
use Salesteer\Exception as Exception;

class CustomerService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, array $params = null, array $headers = []) : Api\Resource\Customer
    {
        $url = $this->buildPath('/%s', $id, Api\Resource\Customer::classUrl());
        return $this->request('get', $url, $params, $headers);
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function list(array $params = null, array $headers = []) : Api\Resource\Customer
    {
        return $this->request('get', Api\Resource\Customer::classUrl(true), $params, $headers);
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(array $params = null, array $headers = []) : Api\Resource\Customer
    {
        return $this->request('post', Api\Resource\Customer::classUrl(), $params, $headers);
    }
}
