<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class InvalidTermException extends BadRequestException
{
    public function __construct(int $numberOfMonths)
    {
        parent::__construct('Term not found for ' . $numberOfMonths . ' months');
    }
}
