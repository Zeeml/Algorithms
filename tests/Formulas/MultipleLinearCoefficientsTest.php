<?php

namespace Zeeml\Algorithms\Tests\Formulas;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\MultipleLinearCoefficients;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

class MultipleLinearCoefficientsTest extends TestCase
{
    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param array $coeffs
     * @expectedException \Zeeml\Algorithms\Exceptions\WrongUsageException
     */
    public function test_calculate_exception_without_dataSet(array $dataSet, array $coeffs)
    {
        (new MultipleLinearCoefficients())->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param array $coeffs
     */
    public function test_calculate(array $dataSet, array $coeffs)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0, 1], [2]));

        $result = (new MultipleLinearCoefficients())
            ->using($dataSet)
            ->calculate()
            ->getResult()
        ;

        $this->assertEquals($coeffs, $result);
    }

    public function getData()
    {
        return [
            [
                [
                    [41.9, 29.1, 251.3],
                    [43.4, 29.3, 251.3],
                    [43.9, 29.5, 248.3],
                    [44.5, 29.7, 267.5],
                    [47.3, 29.9, 273],
                    [47.5, 30.3, 276.5],
                    [47.9, 30.5, 270.3],
                    [50.2, 30.7, 274.9],
                    [52.8, 30.8, 285],
                    [53.2, 30.9, 290],
                    [56.7, 31.5, 297],
                    [57, 31.7, 302.5],
                    [63.5, 31.9, 304.5],
                    [63.3, 32, 309.3],
                    [71.1, 32.1, 321.7],
                    [77, 32.5, 330.7],
                    [77.8, 32.9, 349],
                ],
                [-152.76956142113, 1.2575168806525, 12.029457820725]
            ],
        ];
    }
}
