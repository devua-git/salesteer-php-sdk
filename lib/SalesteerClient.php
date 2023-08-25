<?php

namespace Salesteer;

use Salesteer\Service as Service;
use Salesteer\Exception as Exception;

/**
 * Client used to send requests to Stripe's API.
 *
 * @property Service\CustomerService $customer
 * @property Service\PersonService $person
 * @property Service\PlaceService $place
 * @property Service\OfferService $offer
 */
class SalesteerClient implements SalesteerClientInterface
{
    private array $_configs = [];

    private Service\CoreServiceFactory|null $_serviceFactory = null;

    public function __construct(string|array $configs = [])
    {
        if (is_string($configs)) {
            $configs = ['api_key' => $configs];
        }
        $this->_configs = $configs;
        $this->_configs['api_key'] = $this->_configs['api_key'] ?? Salesteer::getApiKey();

        if (!$this->_configs['api_key']) {
            throw new Exception\InvalidArgumentException('Api key is required.');
        }

        if (!isset($this->_configs['tenant_domain'])) {
            $this->_configs['tenant_domain'] = Salesteer::getTenantDomain();
        }
    }

    public function __get(string $name)
    {
        return $this->getService($name);
    }

    public function getService(string $name)
    {
        if (null === $this->_serviceFactory) {
            $this->_serviceFactory = new Service\CoreServiceFactory($this);
        }

        return $this->_serviceFactory->getService($name);
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
    public function request($method, $path, $responseClass, $params, $headers)
    {
        $requestor = new Api\ApiRequestor(
            $this->_configs['api_key'],
            Salesteer::getApiBase($this->_configs['tenant_domain']),
            $this->_configs,
        );

        $response = $requestor->request($method, $path, $params, $headers);

        $obj = Util\Util::convertToSalesteerObject($response->json, $this, $headers, $responseClass);

        return $obj;
    }
}
