<?php

namespace Salesteer\Service;

class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'customers' => CustomerService::class,
        'places' => PlaceService::class,
        'offers' => OfferService::class,
    ];

    protected function getServiceClass(string $name): string
    {
        return array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
