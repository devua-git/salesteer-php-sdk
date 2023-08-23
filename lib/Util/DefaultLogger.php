<?php

namespace Salesteer\Util;

use Exception as GlobalException;
use Psr\Log\LoggerInterface;
use Salesteer\Exception as Exception;

class DefaultLogger implements LoggerInterface
{
    /** @var int */
    public $messageType = 0;

    /** @var null|string */
    public $destination;

    public function error(string|\Stringable $message, array $context = []): void
    {
        if (count($context) > 0) {
            throw new Exception\BadMethodCallException('DefaultLogger does not currently implement context. Please implement if you need it.');
        }

        if (null === $this->destination) {
            error_log($message, $this->messageType);
        } else {
            error_log($message, $this->messageType, $this->destination);
        }
    }
    public function emergency(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        throw new GlobalException('Non implemented');
    }
}
