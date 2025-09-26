<?php

namespace Salesteer\Service;

use Salesteer\Api\Resource\Offer;
use Salesteer\SalesteerObject;

class OfferService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, ?array $params = null, array $headers = []): Offer
    {
        $url = $this->buildPath('%s', $id, Offer::classUrl());
        $res = $this->request('get', $url, $params, $headers, Offer::class);

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(?array $params = null, array $headers = []): SalesteerObject
    {
        $res = $this->request('get', Offer::classUrl(true), $params, $headers, Offer::class);

        return $res;
    }

    public function create(?array $params = null, array $headers = []): Offer
    {
        $res = $this->request('post', Offer::classUrl(), $params, $headers, Offer::class);

        return $res;
    }
}
