<?php

namespace Salesteer\Service;

/**
 * Service factory class for API resources in the root namespace.
 *
 * @property CustomerService $customers
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'customers' => CustomerService::class,
    ];

    protected function getServiceClass($name)
    {
        return array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
