<?php

namespace Salesteer\Util;

use Salesteer\Api\Resource\ApiPaginateResource;
use Salesteer\SalesteerClientInterface;
use Salesteer\SalesteerObject;

abstract class Util
{
    public static function isList($array)
    {
        if (! is_array($array)) {
            return false;
        }
        if ($array === []) {
            return true;
        }
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }

        return true;
    }

    public static function isPaginateResponse($res)
    {
        return isset($res['data']) && isset($res['current_page']);
    }

    /**
     * Converts a response from the Salesteer API to the corresponding PHP object.
     *
     * @return array|SalesteerObject
     */
    public static function convertToSalesteerObject(
        $res,
        ?SalesteerClientInterface $client = null,
        ?array $headers = null,
        ?string $convertToClass = null,
    ) {
        if (self::isList($res)) {
            $mapped = [];
            foreach ($res as $i) {
                $mapped[] = self::convertToSalesteerObject($i, $client, $headers, $convertToClass);
            }

            return $mapped;
        }

        if (self::isPaginateResponse($res)) {
            return ApiPaginateResource::parse($convertToClass, $res, $client, $headers);
        }

        if (is_array($res)) {
            $class = $convertToClass ?? SalesteerObject::class;

            return $class::constructFrom($res, $client, $headers);
        }

        return $res;
    }

    public static function urlEncode($key)
    {
        $s = urlencode((string) $key);

        // Don't use strict form encoding by changing the square bracket control
        // characters back to their literals. This is fine by the server, and
        // makes these parameter strings easier to read.
        $s = str_replace('%5B', '[', $s);

        return str_replace('%5D', ']', $s);
    }

    /**
     * Returns UNIX timestamp in milliseconds.
     *
     * @return int current time in millis
     */
    public static function currentTimeMillis()
    {
        return (int) round(microtime(true) * 1000);
    }
}
