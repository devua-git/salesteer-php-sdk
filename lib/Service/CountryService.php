<?php

namespace Salesteer\Service;

use Salesteer\Api;
use Salesteer\Exception;
use Salesteer\SalesteerObject;

class CountryService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function search(?array $params = null, array $headers = []): SalesteerObject
    {
        // TODO:MAKE FILTER BUILDER
        $res = $this->request('get', Api\Resource\Country::classUrl(true), $params, $headers, Api\Resource\Country::class);

        return $res;
    }
}
