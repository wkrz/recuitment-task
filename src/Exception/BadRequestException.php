<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use DomainException;

class BadRequestException extends DomainException
{
    public function __construct(string $message = '')
    {
        parent::__construct('Bad Request - ' . $message, 400);
    }
}
