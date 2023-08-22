<?php

namespace Salesteer;

use Salesteer\Util as Util;
use Salesteer\Exception as Exception;

class SalesteerClient
{
    /** @var string default base URL for Salesteer's API */
    const DEFAULT_API_BASE = 'https://api.salesteer.com';

    /** @var array<string, null|string> */
    const DEFAULT_CONFIG = [
        'api_key' => null,
        'tenant_id' => null,
        'version' => Util\ApiVersion::CURRENT,
        'api_base' => self::DEFAULT_API_BASE,
    ];

    /** @var array<string, mixed> */
    private $config;

    public function __construct($config = [])
    {
        if (is_string($config)) {
            $config = ['api_key' => $config];
        } elseif (!is_array($config)) {
            throw new Exception\InvalidArgumentException('$config must be a string or an array');
        }

        $config = array_merge(self::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $this->config = $config;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws Exception\InvalidArgumentException
     */
    private function validateConfig($config)
    {
    }
}
