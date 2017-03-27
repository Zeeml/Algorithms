<?php

namespace Zeeml\Algorithms\Tests\Formulas;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

class SimpleLinearSlopeTest extends TestCase
{
    /**
     * @dataProvider getData
     * @param array $dataSet
     * @expectedException \Zeeml\Algorithms\Exceptions\MissingResultException
     */
    public function testCalculateExceptionUsingDataSet(array $dataSet)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        (new SimpleLinearSlope())->using($dataSet)->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @expectedException \Zeeml\Algorithms\Exceptions\WrongUsageException
     */
    public function testCalculateExceptionWithoutDataSet(array $dataSet)
    {
        (new SimpleLinearSlope())->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param float $slope
     * @expectedException \Zeeml\Algorithms\Exceptions\WrongUsageException
     */
    public function testCalculateWithMeanButEmptyMean(array $dataSet, float $slope)
    {
        $meanFormula = (new Mean())->calculate();
        $formulaResult = new FormulasResults();
        $formulaResult->save($meanFormula);

        (new SimpleLinearSlope())
            ->knowing($formulaResult)
            ->calculate()
        ;
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param float $slope
     */
    public function testCalculate(array $dataSet, float $slope)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $meanFormula = (new Mean())->using($dataSet)->calculate();
        $formulaResult = new FormulasResults();
        $formulaResult->save($meanFormula);

        $simpleLinearSlope = (new SimpleLinearSlope())
            ->using($dataSet)
            ->knowing($formulaResult)
            ->calculate()
        ;

        $this->assertEquals($simpleLinearSlope->getResult(), $slope);
    }

    public function getData()
    {
        return [
            [
                [
                    [1, 1],
                    [2, 3],
                    [4, 3],
                    [3, 2],
                    [5, 5],
                ],
                0.8
            ],
            [
                [
                    [100, 50.1],
                    [110, 55.1],
                    [120, 60.1],
                    [130, 65.1],
                    [140, 70.1],
                    [150, 75.1],
                    [160, 80.1],
                    [170, 85.1],
                    [180, 90.1],
                    [190, 95.1],
                    [200, 100.1],
                    [210, 105.1],
                    [220, 110.1],
                    [230, 115.1],
                    [240, 120.1],
                    [250, 125.1],
                ],
                0.5
            ]
        ];
    }
}