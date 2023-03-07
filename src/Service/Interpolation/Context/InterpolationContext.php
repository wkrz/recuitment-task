<?php

declare(strict_types = 1);

namespace PragmaGoTech\Interview\Service\Interpolation\Context;

use PragmaGoTech\Interview\Enum\Interpolation\InterpolationTypeEnum;
use PragmaGoTech\Interview\Exception\NotFoundInterpolationStrategyException;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Service\Interpolation\InterpolationStrategyInterface;
use PragmaGoTech\Interview\Service\Interpolation\Strategy\LinearInterpolationStrategy;

class InterpolationContext
{
    private InterpolationStrategyInterface $interpolationStrategy;

    /**
     * @throws NotFoundInterpolationStrategyException
     */
    public function __construct(string $interpolationType = InterpolationTypeEnum::LINEAR) {
        switch ($interpolationType) {
            // Here we can add additional strategies (e.g. cosine or cubic) for interpolation using Strategy Pattern.
            default:
                $this->checkExistenceOfInterpolationType($interpolationType);
                $this->interpolationStrategy = new LinearInterpolationStrategy();
        }
    }

    public function calculate(Term $term, float $loanAmount): float
    {
        return $this->interpolationStrategy->calculate($term, $loanAmount);
    }

    private function checkExistenceOfInterpolationType(string $interpolationType): void
    {
        if (!in_array($interpolationType, InterpolationTypeEnum::getList(), true)) {
            throw new NotFoundInterpolationStrategyException($interpolationType);
        }
    }
}
