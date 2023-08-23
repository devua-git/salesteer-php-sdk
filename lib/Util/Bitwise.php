<?php

namespace Salesteer\Util;

class Bitwise
{
    private const MAX_FLAGS = 16;

    public static function isFlagSet(int $bitwiseValue, int $checkBit)
    {
        return ($bitwiseValue & $checkBit) === $checkBit;
    }

    public static function setFlag(int $bitwiseValue, int $checkBit)
    {
        return $bitwiseValue |= $checkBit;
    }

    public static function unsetFlag(int $bitwiseValue, int $checkBit)
    {
        return $bitwiseValue &= ~$checkBit;
    }

    public static function getFlags(int $bitwiseValue): array
    {
        $flagCheck = 1;
        $flags = [];

        for ($i = 0; $i < self::MAX_FLAGS; $i++) {
            if (self::isFlagSet($bitwiseValue, $flagCheck)) {
                $flags[] = $flagCheck;
            }

            $flagCheck = $flagCheck << 1;
        }

        return $flags;
    }
}
