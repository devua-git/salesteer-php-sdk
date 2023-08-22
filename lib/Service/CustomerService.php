<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

class CustomerService extends AbstractService
{
    /**
     * Retrieves the details of an account.
     *
     * @param null|string $id
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws \Salesteer\Exception\ApiErrorException if the request fails
     *
     * @return \Salesteer\Account
     */
    public function retrieve($id, $params = null, $headers = [])
    {
        $url = $this->buildPath('/customers/%s', $id);
        return $this->request('get', $url, $params, $headers);
    }
}
