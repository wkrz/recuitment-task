<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

use PragmaGoTech\Interview\Exception\DuplicateBreakpointException;
use PragmaGoTech\Interview\Exception\InvalidTermException;

class Term
{
    private int $numberOfMonths = 0;
    private array $breakpoints = [];

    /**
     * @throws DuplicateBreakpointException
     */
    public function __construct(int $numberOfMonths)
    {
        $this->setNumberOfMonths($numberOfMonths);
        $this->generateTermBreakpoints();
    }

    public function getNumberOfMonths(): int
    {
        return $this->numberOfMonths;
    }

    public function setNumberOfMonths(int $numberOfMonths): void
    {
        $this->numberOfMonths = $numberOfMonths;
    }

    public function getBreakpoints(): array
    {
        return $this->breakpoints;
    }

    /**
     * @throws DuplicateBreakpointException
     */
    public function addBreakpoint(Breakpoint $breakpoint): void
    {
        $this->validateBreakpoint($breakpoint);
        $this->breakpoints[] = $breakpoint;
    }

    /**
     * @throws DuplicateBreakpointException
     */
    private function generateTermBreakpoints(): void
    {
        $class = __NAMESPACE__;
        $months = $this->getNumberOfMonths();
        $termDataClass = substr($class, 0, strrpos($class, "\\"))
                         .'\\Data\\Term\\TermData'
                         .$months;

        if (!class_exists($termDataClass)) {
            throw new InvalidTermException($months);
        }

        foreach ((new $termDataClass)->getData() as $breakpointData) {
            $breakpoint = new Breakpoint($breakpointData);
            $this->addBreakpoint($breakpoint);
        }
    }

    /**
     * @throws DuplicateBreakpointException
     */
    private function validateBreakpoint(Breakpoint $breakpoint): void
    {
        foreach ($this->getBreakpoints() as $termBreakpoint) {
            if ($termBreakpoint->getAmount() === $breakpoint->getAmount()) {
                throw new DuplicateBreakpointException($breakpoint->getAmount());
            }
        }
    }
}
