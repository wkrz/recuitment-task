<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use PragmaGoTech\Interview\Enum\Breakpoint\BreakpointAttributeEnum;
use PragmaGoTech\Interview\Exception\NotFoundBreakpointAttributeException;

class Breakpoint
{
    private float $amount;
    private float $fee;

    /**
     * @throws NotFoundBreakpointAttributeException
     */
    public function __construct(array $breakpointData)
    {
        $this->validate($breakpointData);
        $this->setAmount($breakpointData[BreakpointAttributeEnum::AMOUNT]);
        $this->setFee($breakpointData[BreakpointAttributeEnum::FEE]);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function setFee(float $fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @throws NotFoundBreakpointAttributeException
     */
    private function validate(array $breakpointData): void
    {
        $breakpointAttributes = BreakpointAttributeEnum::getList();

        if (count(array_intersect(array_keys($breakpointData), $breakpointAttributes)) !== count($breakpointAttributes)) {
            throw new NotFoundBreakpointAttributeException();
        }
    }
}

