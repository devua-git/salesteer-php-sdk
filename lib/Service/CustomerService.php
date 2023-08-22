<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

use Salesteer\Api as Api;
use Salesteer\Exception as Exception;

class CustomerService extends AbstractService
{
    /**
     * Retrieves the details of an account.
     *
     * @param null|string $id
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws Exception\ApiErrorException if the request fails
     *
     * @return Api\Resource\Customer
     */
    public function retrieve($id, $params = null, $headers = [])
    {
        $url = $this->buildPath('/customers/%s', $id);
        return $this->request('get', $url, $params, $headers);
    }
}
