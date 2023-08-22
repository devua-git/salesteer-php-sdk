<?php

namespace Salesteer\Api\Resource;

use Salesteer\SalesteerObject;
use Salesteer\Exception as Exception;
use Salesteer\Salesteer;

abstract class ApiResource extends SalesteerObject
{
    /**
     * @throws Exception\ApiErrorException
     *
     * @return ApiResource the refreshed resource
     */
    public function refresh()
    {
        $url = $this->instanceUrl();

        $response = $this->request(
            'get',
            $url,
            null,
            $this->_headers
        );
        $this->refreshFrom($response->json, $this->_opts);

        return $this;
    }

    /**
     * @return string the endpoint URL for the given class
     */
    public static function classUrl()
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/v1/foo/bars".
        $objectName = str_replace('.', '/', static::OBJECT_NAME);
        $version = Salesteer::getApiVersion();

        if($version){
            return "/$version/{$objectName}s";
        }

        return "{$objectName}s";
    }

    /**
     * @param null|string $id the ID of the resource
     *
     * @throws Exception\UnexpectedValueException if $id is null
     *
     * @return string the instance endpoint URL for the given class
     */
    public static function resourceUrl($id = null)
    {
        if (null === $id) {
            $class = static::class;
            $message = 'Could not determine which URL to request: '
               . "{$class} instance has invalid ID: {$id}";

            throw new Exception\UnexpectedValueException($message);
        }

        $base = static::classUrl();
        $resourceId = urlencode($id);

        return "{$base}/{$resourceId}";
    }

    public function instanceUrl()
    {
        return static::resourceUrl($this['id']);
    }

    public static function baseUrl()
    {
        return Salesteer::getApiBase();
    }
}
