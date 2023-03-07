<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Enum\Interpolation;

class InterpolationTypeEnum
{
    public const LINEAR = 'linear';

    public static function getAll(): array
    {
        return [
            self::LINEAR,
        ];
    }
}
