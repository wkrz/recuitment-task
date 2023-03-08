<?php

declare(strict_types = 1);

namespace PragmaGoTech\Interview\Service\Interpolation\Strategy;

use PragmaGoTech\Interview\Exception\LoanAmountOutOfRangeException;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Service\Interpolation\InterpolationStrategyInterface;

class LinearInterpolationStrategy implements InterpolationStrategyInterface
{
    public function calculate(Term $term, float $loanAmount): float
    {
        foreach ($term->getBreakpoints() as $breakpoint) {
            if ($breakpoint->getAmount() === $loanAmount) {
                return $breakpoint->getFee();
            }
        }

        [$lowerBound, $upperBound] = $this->getLowerAndUpperBoundsBreakpoints($term, $loanAmount);

        $base = $lowerBound->getFee();
        $delta = ($loanAmount - $lowerBound->getAmount()) / ($upperBound->getAmount() - $lowerBound->getAmount());
        $delta *= ($upperBound->getFee() - $lowerBound->getFee());
        $fee = $base + $delta;
        $grossLoan = $loanAmount + $fee;
        $grossLoan = ceil($grossLoan / 5) * 5;

        return round($grossLoan - $loanAmount, 2);
    }

    /**
     * @throws LoanAmountOutOfRangeException
     */
    private function getLowerAndUpperBoundsBreakpoints(Term $term, float $loanAmount): array
    {
        $lowerBound = null;
        $upperBound = null;

        foreach ($term->getBreakpoints() as $breakpoint) {
            $breakpointAmount = $breakpoint->getAmount();

            if ($breakpointAmount < $loanAmount) {
                $lowerBound = $breakpoint;
            }

            if ($breakpointAmount > $loanAmount) {
                $upperBound = $breakpoint;
            }
        }

        if (!$lowerBound || !$upperBound) {
            throw new LoanAmountOutOfRangeException($loanAmount);
        }

        return [$lowerBound, $upperBound];
    }
}
