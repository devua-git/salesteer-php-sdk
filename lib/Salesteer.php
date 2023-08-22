<?php

namespace Salesteer;

use Salesteer\Util as Util;

class Salesteer
{
    const DEFAULT_CENTRAL_API_BASE = 'http://api.crm.local/api';
    const DEFAULT_TENANT_API_BASE = 'http://api.crm.local/app';

    public static string $apiKey;

    public static string $tenantId;

    public static string $tenantDomain;

    public static $apiVersion = Util\ApiVersion::CURRENT;

    public static $logger = null;

    public static $enableTelemetry = true;

    const VERSION = '1.0.0';

    public static function getApiKey()
    {
        return self::$apiKey;
    }

    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    public function getApiBase(){
        if(self::$tenantDomain){
            return self::DEFAULT_TENANT_API_BASE;
        }else{
            return self::DEFAULT_CENTRAL_API_BASE;
        }
    }

    public static function getTenantDomain()
    {
        return self::$tenantDomain;
    }

    public static function setTenantDomain($tenantDomain)
    {
        self::$tenantDomain = $tenantDomain;
    }

    public static function getTenantId()
    {
        return self::$tenantDomain;
    }

    public static function setTenantId($tenantId)
    {
        self::$tenantId = $tenantId;
    }

    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    public static function getLogger()
    {
        if (null === self::$logger) {
            return new Util\DefaultLogger();
        }

        return self::$logger;
    }

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
