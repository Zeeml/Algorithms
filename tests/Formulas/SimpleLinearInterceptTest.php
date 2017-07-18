<?php

namespace Zeeml\Algorithms\Tests\Formulas;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\SimpleLinearIntercept;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

class SimpleLinearInterceptTest extends TestCase
{
    /**
     * @dataProvider getData
     * @param array $dataSet
     */
    public function testCalculateExceptionNoMeanNoSlope(array $dataSet)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $this->expectException(MissingResultException::class);
        (new SimpleLinearIntercept())
            ->using($dataSet)
            ->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @expectedException \Zeeml\Algorithms\Exceptions\MissingResultException
     */
    public function testCalculateExceptionNoMeanNoSlope2(array $dataSet)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $mean = (new Mean())
            ->using($dataSet)
            ->calculate();

        $formulaResult = new FormulasResults();
        $formulaResult->save($mean);

        (new SimpleLinearIntercept($dataSet))
            ->knowing($formulaResult)
            ->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @expectedException \Zeeml\Algorithms\Exceptions\MissingResultException
     */
    public function testCalculateExceptionValidMeanNoSlope(array $dataSet)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $this->expectException(MissingResultException::class);
        $mean = (new Mean())
            ->using($dataSet)
            ->calculate();

        $formulaResult = new FormulasResults();
        $formulaResult->save($mean);

        (new SimpleLinearIntercept($dataSet))
            ->knowing($formulaResult)
            ->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param float $intercept
     */
    public function testCalculate(array $dataSet, float $intercept)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $formulaResults = new FormulasResults();

        $meanFormula = (new Mean())
            ->using($dataSet)
            ->calculate();
        $formulaResults->save($meanFormula);

        $simpleLinearSlope = (new SimpleLinearSlope($dataSet))
            ->using($dataSet)
            ->knowing($formulaResults)
            ->calculate()
        ;
        $formulaResults->save($simpleLinearSlope);

        $simpleLinearIntercept = (new SimpleLinearIntercept($dataSet))
            ->knowing($formulaResults)
            ->calculate()
        ;

        $this->assertEquals($simpleLinearIntercept->getResult(), $intercept);
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
                0.4
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
                0.1
            ]
        ];
    }
}