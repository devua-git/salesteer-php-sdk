<?php

namespace Salesteer;

use Salesteer\Util as Util;
use Psr\Log\LoggerInterface;

abstract class Salesteer
{
    const VERSION = '1.0.0';

    const DEFAULT_CENTRAL_API_BASE = 'http://api.crm.local/api';

    const DEFAULT_TENANT_API_BASE = 'http://api.crm.local/app';

    private static string|null $_apiKey = null;

    private static string|null $_tenantId = null;

    private static string|null $_tenantDomain = null;

    private static string|null $_apiVersion = Util\ApiVersion::CURRENT;

    private static LoggerInterface|null $_logger = null;

    private static bool $_enableTelemetry = true;

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

    public static function getTenantId()
    {
        return self::$_tenantDomain;
    }

    public static function setTenantId($tenantId)
    {
        self::$_tenantId = $tenantId;
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
}
