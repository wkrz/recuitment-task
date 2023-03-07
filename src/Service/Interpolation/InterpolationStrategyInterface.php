<?php

declare(strict_types = 1);

namespace PragmaGoTech\Interview\Service\Interpolation;

use PragmaGoTech\Interview\Model\Term;

interface InterpolationStrategyInterface
{
    public function calculate(Term $term, float $loanAmount): float;
}
