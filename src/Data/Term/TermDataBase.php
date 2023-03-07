<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Data\Term;

abstract class TermDataBase
{
    protected array $data = [];

    public function getData(): array
    {
        return $this->data;
    }
}
