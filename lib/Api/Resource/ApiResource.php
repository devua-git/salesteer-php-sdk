<?php

namespace Salesteer\Api\Resource;

use Salesteer\Exception;
use Salesteer\Salesteer;
use Salesteer\SalesteerObject;

abstract class ApiResource extends SalesteerObject
{
    const PLURAL_NAME = null;

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
        $this->refreshFrom($response, $this->_headers);

        return $this;
    }

    public static function classUrl(?bool $isApiPlural = null): string
    {
        $isApiPlural = $isApiPlural ?? static::IS_API_PLURAL;
        $objectName = static::OBJECT_NAME;

        $resourceName = $isApiPlural
            ? static::PLURAL_NAME ?? "{$objectName}s"
            : "{$objectName}";

        $version = Salesteer::getApiVersion();

        if ($version) {
            return "/$version/{$resourceName}";
        }

        return "/{$resourceName}";
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
