<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\Fee\FeeCalculator;

class FreeCalculatorTest extends TestCase
{
    public function testLinearInterpolation(): void
    {
        $calculator = new FeeCalculator();
        $loanProposal = new LoanProposal(24, 30000);
        $fee = $calculator->calculate($loanProposal);
        $this->assertEquals(460, $fee);

        $loanProposal1 = new LoanProposal(12, 19250);
        $fee = $calculator->calculate($loanProposal1);
        $this->assertEquals(385, $fee);
    }

    public function testLinearInterpolationOneDecimal(): void
    {
        $calculator = new FeeCalculator();
        $loanProposal = new LoanProposal(24, 3954.7);
        $fee = $calculator->calculate($loanProposal);
        $this->assertEquals(160.3, $fee);
    }

    public function testLinearInterpolationTwoDecimals(): void
    {
        $calculator = new FeeCalculator();
        $loanProposal = new LoanProposal(12, 5974.88);
        $fee = $calculator->calculate($loanProposal);
        $this->assertEquals(120.12, $fee);
    }
}
