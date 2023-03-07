<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service\Fee;

use PragmaGoTech\Interview\Enum\Interpolation\InterpolationTypeEnum;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Service\Interpolation\Context\InterpolationContext;

class FeeCalculator implements FeeCalculatorInterface
{
    private InterpolationContext $interpolationStrategy;

    public function __construct(string $interpolationType = InterpolationTypeEnum::LINEAR)
    {
        $this->interpolationStrategy = $this->getInterpolationStrategy($interpolationType);
    }

    public function calculate(LoanProposal $loanProposal): float
    {
        return $this->interpolationStrategy->calculate(new Term($loanProposal->getTerm()), $loanProposal->getAmount());
    }

    private function getInterpolationStrategy(string $interpolationType): InterpolationContext
    {
        return new InterpolationContext($interpolationType);
    }
}
