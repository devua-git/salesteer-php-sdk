<?php

namespace Salesteer\Service;

class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'customer' => CustomerService::class,
        'person' => PersonService::class,
        'place' => PlaceService::class,
        'offer' => OfferService::class,
        'country' => CountryService::class,
        'state' => StateService::class,
        'province' => ProvinceService::class,
        'city' => CityService::class,
        'user' => UserService::class,
    ];

    protected function getServiceClass(string $name): string
    {
        return array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
