<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service\Fee;

use PragmaGoTech\Interview\Model\LoanProposal;

interface FeeCalculatorInterface
{
    public function calculate(LoanProposal $loanProposal): float;
}
