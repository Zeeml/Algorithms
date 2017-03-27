<?php

namespace Zeeml\Algorithms\Tests;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Calculator;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\Algorithms\Tests\Fixtures\Formula1;
use Zeeml\Algorithms\Tests\Fixtures\Formula2;
use Zeeml\Algorithms\Tests\Fixtures\Formula3;
use Zeeml\Algorithms\Tests\Fixtures\Formula4;
use Zeeml\Algorithms\Tests\Fixtures\Formula5;

class CalculatorTest extends TestCase
{
    protected $formula1;
    protected $formula2;
    protected $formula3;
    protected $formula4;
    protected $formula5;

    public function setUp()
    {
        $this->formula1 = new Formula1();
        $this->formula2 = new Formula2();
        $this->formula3 = new Formula3();
        $this->formula4 = new Formula4();
        $this->formula5 = new Formula5();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     */
    public function test_basic_calculate(array $dataSet)
    {
        $calculator = new Calculator($dataSet);
        $calculator
            ->calculate($this->formula1)
            ->then($this->formula2)
            ->then($this->formula3)
            ->then($this->formula4)
            ->then($this->formula5)
        ;

        $this->assertInstanceOf(Calculator::class, $calculator);

        $this->assertEquals($calculator->getFormulasResults()->getAll(), [Formula1::class => 1, Formula2::class => 2]);
        $this->assertEquals($calculator->getFormulasResults()->get(Formula1::class), 1);
        $this->assertEquals($calculator->getFormulasResults()->get(Formula2::class), 2);
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     */
    public function test_calculate_twice(array $dataSet)
    {
        $calculator = new Calculator($dataSet);

        $calculator
            ->calculate($this->formula1)
        ;

        $this->assertInstanceOf(Calculator::class, $calculator);
        $this->assertEquals($calculator->getFormulasResults()->getAll(), [Formula1::class => 1]);

        $calculator
            ->calculate($this->formula1)
        ;

        $this->assertInstanceOf(Calculator::class, $calculator);
        $this->assertEquals($calculator->getFormulasResults()->getAll(), [Formula1::class => 1]);

        $this->assertCount(1, $calculator->getFormulasResults()->getAll());
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     */
    public function test_then(array $dataSet)
    {
        $calculator = new Calculator($dataSet);
        $calculator
            ->calculate($this->formula1)
            ->then($this->formula2)
            ->then($this->formula3)
            ->then($this->formula4)
            ->then($this->formula5)
        ;

        $this->assertInstanceOf(Calculator::class, $calculator);
        $this->assertEquals($calculator->getFormulasResults()->get(Formula1::class), 1);
        $this->assertEquals($calculator->getFormulasResults()->get(Formula2::class), 2);
        $this->assertEquals($calculator->getFormulasResults()->getAll(), [Formula1::class => 1, Formula2::class => 2]);
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     */
    public function test_getResult(array $dataSet)
    {
        $calculator = new Calculator($dataSet);
        $calculator
            ->calculate($this->formula1)
            ->then($this->formula2)
            ->then($this->formula3)
            ->then($this->formula4)
            ->then($this->formula5)
        ;

        $this->assertInstanceOf(Calculator::class, $calculator);
        $this->assertEquals($calculator->getFormulasResults()->get(Formula1::class), 1);
        $this->assertEquals($calculator->getFormulasResults()->get(Formula2::class), 2);
        $this->assertEquals($calculator->getFormulasResults()->getAll(), [Formula1::class => 1, Formula2::class => 2]);

    }

    /**
     * the data provider (provides DataSet, Mean and Slope)
     * @return array
     */
    public function getData()
    {
        return [
            [
                [
                    [ [1], [1]],
                    [ [2], [3]],
                    [ [4], [3]],
                    [ [3], [2]],
                    [ [5], [5]],
                ],
            ],
            [
                [
                    [ [100] , [50.1] ],
                    [ [110] , [55.1] ],
                    [ [120] , [60.1] ],
                    [ [130] , [65.1] ],
                    [ [140] , [70.1] ],
                    [ [150] , [75.1] ],
                    [ [160] , [80.1] ],
                    [ [170] , [85.1] ],
                    [ [180] , [90.1] ],
                    [ [190] , [95.1] ],
                    [ [200] , [100.1] ],
                    [ [210] , [105.1] ],
                    [ [220] , [110.1] ],
                    [ [230] , [115.1] ],
                    [ [240] , [120.1] ],
                    [ [250] , [125.1] ],
                ],
            ]
        ];
    }
}
