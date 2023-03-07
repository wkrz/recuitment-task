<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

class LoanProposal
{
    private int $term;
    private float $amount;

    public function __construct(int $term, float $amount)
    {
        $this->term = $term;
        $this->amount = $amount;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
