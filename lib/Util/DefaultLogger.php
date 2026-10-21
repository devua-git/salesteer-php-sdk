<?php

namespace Salesteer\Util;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

class DefaultLogger extends AbstractLogger
{
    /** @var int */
    public $messageType = 0;

    /** @var null|string */
    public $destination;

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (! in_array($level, [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::NOTICE,
            LogLevel::INFO,
            LogLevel::DEBUG,
        ], true)) {
            throw new InvalidArgumentException('Invalid log level.');
        }

        if ($this->destination === null) {
            error_log((string) $message, $this->messageType);
        } else {
            error_log((string) $message, $this->messageType, $this->destination);
        }
    }
}
