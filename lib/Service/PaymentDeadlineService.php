<?php

namespace Salesteer\Service;

use Salesteer\Api\Resource\PaymentDeadline;
use Salesteer\SalesteerObject;

class PaymentDeadlineService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, ?array $params = null, array $headers = []): PaymentDeadline
    {
        $url = $this->buildPath('%s', $id, PaymentDeadline::classUrl());
        $res = $this->request('get', $url, $params, $headers, PaymentDeadline::class);

        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(?array $params = null, array $headers = []): SalesteerObject
    {
        $res = $this->request('get', PaymentDeadline::classUrl(true), $params, $headers, PaymentDeadline::class);

        return $res;
    }

    public function create(?array $params = null, array $headers = []): PaymentDeadline
    {
        $res = $this->request('post', PaymentDeadline::classUrl(), $params, $headers, PaymentDeadline::class);

        return $res;
    }
}
