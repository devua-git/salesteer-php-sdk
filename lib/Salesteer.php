<?php

namespace Salesteer;

use Salesteer\Util as Util;

class Salesteer
{
    /** @var string The Salesteer API key to be used for requests. */
    public static $apiKey;

    /** @var string The Salesteer tenant_id to be used for Connect requests. */
    public static $tenantId;

    /** @var string The base URL for the Salesteer API. */
    public static $apiBase = 'https://api.salesteer.com';

    /** @var string The version of the Salesteer API to use for requests. */
    public static $apiVersion = Util\ApiVersion::CURRENT;

    /**
     * @var null|Util\LoggerInterface the logger to which the library will
     *   produce messages
     */
    public static $logger = null;

    /** @var bool Whether client telemetry is enabled. Defaults to true. */
    public static $enableTelemetry = true;

    const VERSION = '1.0.0';

    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    public static function getTenantId()
    {
        return self::$tenantId;
    }

    /**
     * Sets the client_id to be used for Connect requests.
     *
     * @param string $tenantId
     */
    public static function setTenantId($tenantId)
    {
        self::$tenantId = $tenantId;
    }

    /**
     * @return string the API version used for requests
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion the API version to use for requests
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @return Util\LoggerInterface the logger to which the library will
     *   produce messages
     */
    public static function getLogger()
    {
        if (null === self::$logger) {
            return new Util\DefaultLogger();
        }

        return self::$logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface|Util\LoggerInterface $logger the logger to which the library
     *   will produce messages
     */
    public static function setLogger($logger)
    {
        self::$logger = $logger;
    }

    public static function getEnableTelemetry()
    {
        return self::$enableTelemetry;
    }

    public static function setEnableTelemetry($enableTelemetry)
    {
        self::$enableTelemetry = $enableTelemetry;
    }
}
