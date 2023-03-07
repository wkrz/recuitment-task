<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Enum\Breakpoint;

class BreakpointAttributeEnum
{
    public const AMOUNT  = 'amount';
    public const FEE = 'fee';

    public static function getAll(): array
    {
        return [
            self::AMOUNT,
            self::FEE,
        ];
    }
}
