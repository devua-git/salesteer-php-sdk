<?php

namespace Salesteer\Util;

use Salesteer\SalesteerClientInterface;
use Salesteer\SalesteerObject;

abstract class Util
{
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }
        if ([] === $array) {
            return true;
        }
        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }

        return true;
    }

    //TODO: Remove in future - this is a workaround for avoid bad SalesteerObject conversion
    public static function convertTo(SalesteerObject $object, string $class){
        return $class::constructFrom($object->toArray(), $object->getClient());
    }

    /**
     * Converts a response from the Salesteer API to the corresponding PHP object.
     *
     * @param array $resp the response from the Salesteer API
     * @param array $opts
     *
     * @return array|SalesteerObject
     */
    public static function convertToSalesteerObject(
        $res,
        SalesteerClientInterface $client = null,
        array $headers = null)
    {
        if (self::isList($res)) {
            $mapped = [];
            foreach ($res as $i) {
                $mapped[] = self::convertToSalesteerObject($i, $client, $headers);
            }

            return $mapped;
        }

        if (is_array($res)) {
            $types = ObjectTypes::mapping;
            if (isset($res['object']) && is_string($res['object']) && isset($types[$res['object']])) {
                $class = $types[$res['object']];
            } else {
                $class = \Salesteer\SalesteerObject::class;
            }

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
