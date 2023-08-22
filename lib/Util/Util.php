<?php

namespace Salesteer\Util;

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

    /**
     * Converts a response from the Salesteer API to the corresponding PHP object.
     *
     * @param array $resp the response from the Salesteer API
     * @param array $opts
     *
     * @return array|SalesteerObject
     */
    public static function convertToSalesteerObject($res)
    {
        if (self::isList($res)) {
            $mapped = [];
            foreach ($res as $i) {
                $mapped[] = self::convertToSalesteerObject($i);
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

            return $class::constructFrom($res);
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
