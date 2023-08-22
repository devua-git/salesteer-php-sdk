<?php

namespace Salesteer;

use Salesteer\Service as Service;

/**
 * Client used to send requests to Stripe's API.
 *
 * @property Service\CustomerService $customers
 */
class SalesteerClient implements SalesteerClientInterface
{
    private Service\CoreServiceFactory|null $coreServiceFactory = null;

    public function __get(string $name)
    {
        return $this->getService($name);
    }

    public function getService(string $name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new Service\CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->getService($name);
    }

    /**
     * Sends a request to Salesteer's API.
     *
     * @param 'delete'|'get'|'post'|'patch'|'put' $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array $headers
     *
     * @return SalesteerObject the object returned by Salesteer's API
     */
    public function request($method, $path, $params, $headers)
    {
        $requestor = new Api\ApiRequestor();
        $response = $requestor->request($method, $path, $params, $headers);

        $obj = Util\Util::convertToSalesteerObject($response->json, $headers);

        return $obj;
    }
}
