<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class NotFoundInterpolationStrategyException extends BadRequestException
{
    public function __construct(string $interpolationType)
    {
        parent::__construct('Not found ' . $interpolationType . ' Interpolation strategy');
    }
}
