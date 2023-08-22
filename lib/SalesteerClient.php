<?php

namespace Salesteer;

use Salesteer\Service as Service;

class SalesteerClient implements SalesteerClientInterface
{
    /** @var CoreServiceFactory */
    private $coreServiceFactory;

    public function __get($name)
    {
        return $this->getService($name);
    }

    public function getService($name)
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
