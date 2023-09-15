<?php

namespace Salesteer;

use Salesteer\Util as Util;
use Salesteer\Exception as Exception;
use Psr\Log\LoggerInterface;

/**
 * @method static Service\CustomerService customer()
 * @method static Service\PersonService person()
 * @method static Service\PlaceService place()
 * @method static Service\OfferService offer()
 * @method static Service\CityService city()
 * @method static Service\ProvinceService province()
 * @method static Service\StateService state()
 * @method static Service\CountryService country()
 */
abstract class Salesteer
{
    const VERSION = '1.0.0';

    private static string $_apiBase = 'https://api.salesteer.com';

    private static string|null $_apiKey = null;

    private static string|null $_tenantDomain = null;

    private static string|null $_apiVersion = Util\ApiVersion::CURRENT;

    private static LoggerInterface|null $_logger = null;

    private static bool $_enableTelemetry = true;

    private static SalesteerClient|null $_client = null;

    public static function getApiKey()
    {
        return self::$_apiKey;
    }

    public static function setApiKey($apiKey)
    {
        self::$_apiKey = $apiKey;
    }

    public static function getApiBase($domain = null)
    {
        if ($domain ?? self::$_tenantDomain) {
            return self::$_apiBase . '/api';
        } else {
            return self::$_apiBase . '/central';
        }
    }

    public static function setApiBase(string $apiBase)
    {
        self::$_apiBase = $apiBase;
    }

    public static function getTenantDomain()
    {
        return self::$_tenantDomain;
    }

    public static function setTenantDomain($tenantDomain)
    {
        self::$_tenantDomain = $tenantDomain;
    }

    public static function getApiVersion()
    {
        return self::$_apiVersion;
    }

    public static function setApiVersion($apiVersion)
    {
        self::$_apiVersion = $apiVersion;
    }

    public static function getLogger()
    {
        if (null === self::$_logger) {
            return new Util\DefaultLogger();
        }

        return self::$_logger;
    }

    public static function setLogger($logger)
    {
        self::$_logger = $logger;
    }

    public static function getEnableTelemetry()
    {
        return self::$_enableTelemetry;
    }

    public static function setEnableTelemetry($enableTelemetry)
    {
        self::$_enableTelemetry = $enableTelemetry;
    }

    public static function getClient()
    {
        if (null === self::$_client) {
            self::$_client = new SalesteerClient();
        }
        return self::$_client;
    }

    public static function __callStatic($method, array $args = [])
    {
        if (count($args) > 0) {
            throw new Exception\InvalidArgumentException('You cannot pass arguments to static services.');
        }
        return self::getService($method);
    }

    public static function getService(string $name)
    {
        return self::getClient()->getService($name);
    }
}
