<?php

// File generated from our OpenAPI spec

namespace Salesteer\Service;

use Salesteer\SalesteerObject;
use Salesteer\Api as Api;
use Salesteer\Util as Util;
use Salesteer\Exception as Exception;

class CustomerService extends AbstractService
{
    const TYPE_STRING_MAP = [
        'prospect'=> 1 << 0,
        'account' => 1 << 1,
        'supplier' => 1 << 2,
    ];

    /**
     * @param array<int, 'prospect'|'account'|'supplier'>|'prospect'|'account'|'supplier' $types the customer types
     */
    public function getCustomerType(array|string $types){
        if(!is_array($types)){
            $types = [$types];
        }

        $type = 0;
        foreach($types as $stringType){
            $type = Util\Bitwise::setFlag($type, self::TYPE_STRING_MAP[$stringType]);
        }

        return $type;
    }

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
