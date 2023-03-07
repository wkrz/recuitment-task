<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class DuplicateBreakpointException extends BadRequestException
{
    public function __construct(float $amount)
    {
        parent::__construct('Breakpoint with amount ' . $amount . ' already exists');
    }
}
