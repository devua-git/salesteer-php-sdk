<?php

namespace Salesteer;

use Salesteer\Util as Util;
use Salesteer\Exception as Exception;
use Psr\Log\LoggerInterface;

/**
 * @method static Service\CustomerService customers()
 * @method static Service\PlaceService places()
 */
abstract class Salesteer
{
    const VERSION = '1.0.0';

    const DEFAULT_CENTRAL_API_BASE = 'http://api.crm.local/api';

    const DEFAULT_TENANT_API_BASE = 'http://api.crm.local/app';

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

    public static function getApiBase(){
        if(self::$_tenantDomain){
            return self::DEFAULT_TENANT_API_BASE;
        }else{
            return self::DEFAULT_CENTRAL_API_BASE;
        }
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

    public static function __callStatic($method, $args = null)
    {
        if(method_exists(self::class, $method)){
            self::{$method}($args);
        }

        if(null !== $args){
            throw new Exception\InvalidArgumentException('You cannot pass arguments to static services.');
        }
        return self::getService($method);
    }

    public static function getService(string $name)
    {
        return self::getClient()->getService($name);
    }
}
