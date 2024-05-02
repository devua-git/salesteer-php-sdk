<?php

namespace Salesteer\Service;

use Salesteer\SalesteerObject;
use Salesteer\Api as Api;
use Salesteer\Util as Util;
use Salesteer\Exception as Exception;

class EventService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, array $params = null, array $headers = []): Api\Resource\Event
    {
        $url = $this->buildPath('%s', $id, Api\Resource\Event::classUrl());
        $res = $this->request('get', $url, $params, $headers, Api\Resource\Event::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(array $params = null, array $headers = []): SalesteerObject
    {
        //TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\Event::classUrl(true), $params, $headers, Api\Resource\Event::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function create(array $params = null, array $headers = []): Api\Resource\Event
    {
        $res = $this->request('post', Api\Resource\Event::classUrl(), $params, $headers, Api\Resource\Event::class);
        return $res;
    }
}
