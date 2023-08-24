<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

use Salesteer\Api as Api;
use Salesteer\Util as Util;
use Salesteer\Exception as Exception;

class PlaceService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, array $params = null, array $headers = []) : Api\Resource\Place
    {
        $url = $this->buildPath('%s', $id, Api\Resource\Place::classUrl());
        $res = $this->request('get', $url, $params, $headers, Api\Resource\Place::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(array $params = null, array $headers = []) : Api\Resource\Place
    {
        $res = $this->request('post', Api\Resource\Place::classUrl(), $params, $headers, Api\Resource\Place::class);
        return $res;
    }
}
