<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Enum;

use ReflectionClass;

abstract class Enum
{
    public static function getList(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
