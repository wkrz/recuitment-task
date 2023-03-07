<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class LoanAmountOutOfRangeException extends BadRequestException
{
    public function __construct(float $loanAmount)
    {
        parent::__construct('The loan amount ' . $loanAmount . ' is out of the range');
    }
}
