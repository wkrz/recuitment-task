<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Unit;

use Closure;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Enum\Breakpoint\BreakpointAttributeEnum;
use PragmaGoTech\Interview\Exception\DuplicateBreakpointException;
use PragmaGoTech\Interview\Exception\InvalidTermException;
use PragmaGoTech\Interview\Exception\LoanAmountOutOfRangeException;
use PragmaGoTech\Interview\Exception\NotFoundBreakpointAttributeException;
use PragmaGoTech\Interview\Exception\NotFoundInterpolationStrategyException;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Service\Fee\FeeCalculator;
use Throwable;

class FreeCalculatorTest extends TestCase
{
    public function testDefault(): void
    {
        $calculator = new FeeCalculator();
        $loanProposal = new LoanProposal(24, 11500);
        $fee = $calculator->calculate($loanProposal);
        $this->assertEquals(460, $fee);

        $loanProposal1 = new LoanProposal(12, 19250);
        $fee = $calculator->calculate($loanProposal1);
        $this->assertEquals(385, $fee);
    }

    public function testOneDecimal(): void
    {
        $calculator = new FeeCalculator();
        $loanProposal = new LoanProposal(24, 3954.7);
        $fee = $calculator->calculate($loanProposal);
        $this->assertEquals(160.3, $fee);
    }

    public function testTwoDecimals(): void
    {
        $calculator = new FeeCalculator();
        $loanProposal = new LoanProposal(12, 5974.88);
        $fee = $calculator->calculate($loanProposal);
        $this->assertEquals(120.12, $fee);
    }

    public function testInvalidTerm(): void
    {
        $this->runUnderExceptionHandler(function () {
            $calculator = new FeeCalculator();
            $loanProposal = new LoanProposal(48, 15000);
            $calculator->calculate($loanProposal);
        }, [
            'class' => InvalidTermException::class,
            'message' => 'Bad Request - Term not found for 48 months',
        ]);
    }

    public function testLoanAmountOutOfRange(): void
    {
        $this->runUnderExceptionHandler(function () {
            $calculator = new FeeCalculator();
            $loanProposal = new LoanProposal(12, 30000);
            $calculator->calculate($loanProposal);
        }, [
            'class' => LoanAmountOutOfRangeException::class,
            'message' => 'Bad Request - The loan amount 30000 is out of the range',
        ]);
    }

    public function testNotFoundInterpolationStrategy(): void
    {
        $this->runUnderExceptionHandler(function () {
            new FeeCalculator('Cubic');
        }, [
            'class' => NotFoundInterpolationStrategyException::class,
            'message' => 'Bad Request - Not found Cubic Interpolation strategy',
        ]);
    }

    public function testNotFoundBreakpointAttribute(): void
    {
        $this->runUnderExceptionHandler(function () {
            new Breakpoint([BreakpointAttributeEnum::AMOUNT => 1250]);
        }, [
            'class' => NotFoundBreakpointAttributeException::class,
            'message' => 'Bad Request - Required breakpoint attributes are missing',
        ]);
    }

    public function testDuplicateBreakpoint(): void
    {
        $this->runUnderExceptionHandler(function () {
            $term = new Term(24);
            $breakpoint = new Breakpoint([BreakpointAttributeEnum::AMOUNT => 7000, BreakpointAttributeEnum::FEE => 300]);
            $term->addBreakpoint($breakpoint);
        }, [
            'class' => DuplicateBreakpointException::class,
            'message' => 'Bad Request - Breakpoint with amount 7000 already exists',
        ]);
    }

    private function runUnderExceptionHandler(Closure $closure, array $expectedExceptionData): void
    {
        $expectedExceptionClass = $expectedExceptionData['class'];

        try {
            $closure();
        } catch (Throwable $exception) {
            if (get_class($exception) !== $expectedExceptionClass) {
                $this->fail('Exception ' . $expectedExceptionClass . ' expected but ' . get_class($exception) . ' caught');
            }

            $this->assertEquals($expectedExceptionData['message'], $exception->getMessage());
        } finally {
            if (!isset($exception)) {
                $this->fail('Exception ' . $expectedExceptionClass . ' expected but none caught');
            }
        }
    }
}
