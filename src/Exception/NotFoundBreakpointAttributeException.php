<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class NotFoundBreakpointAttributeException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct('Required breakpoint attributes are missing');
    }
}
