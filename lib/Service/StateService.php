<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

use Salesteer\SalesteerObject;
use Salesteer\Api as Api;
use Salesteer\Exception as Exception;

class StateService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(array $params = null, array $headers = []) : SalesteerObject
    {
        //TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\State::classUrl(true), $params, $headers, Api\Resource\State::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(array $params = null, array $headers = []) : Api\Resource\State
    {
        $res = $this->request('post', Api\Resource\State::classUrl(), $params, $headers, Api\Resource\State::class);
        return $res;
    }
}
