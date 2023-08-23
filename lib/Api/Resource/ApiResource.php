<?php

namespace Salesteer\Api\Resource;

use Salesteer\Salesteer;
use Salesteer\SalesteerObject;
use Salesteer\Exception as Exception;

abstract class ApiResource extends SalesteerObject
{
    const IS_API_PLURAL = false;

    /**
     * @throws Exception\ApiErrorException
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
        $this->refreshFrom($response->json, $this->_headers);

        return $this;
    }

    public static function classUrl(bool $isApiPlural = false) : string
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/v1/foo/bars".
        $objectName = str_replace('.', '/', static::OBJECT_NAME);
        $plurality = ($isApiPlural || self::IS_API_PLURAL) === true ? 's' : '';
        $version = Salesteer::getApiVersion();

        if($version){
            return "/$version/{$objectName}{$plurality}";
        }

        return "/{$objectName}{$plurality}";
    }

    public static function resourceUrl(string|int $id)
    {
        $base = static::classUrl();
        $resourceId = urlencode($id);

        return "{$base}/{$resourceId}";
    }

    public function instanceUrl()
    {
        return static::resourceUrl($this->id);
    }
}
