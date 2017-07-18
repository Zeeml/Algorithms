<?php

namespace Zeeml\Algorithms\Tests\Formulas;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\SimpleLinearIntercept;
use Zeeml\Algorithms\Formulas\SimpleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

class SimpleLinearPredictionTest extends TestCase
{
    /**
     * @dataProvider getData
     * @param array $dataSet
     * @expectedException \Zeeml\Algorithms\Exceptions\MissingResultException
     */
    public function test_calculate_exception_no_slope_no_intercept(array $dataSet)
    {
        (new SimpleLinearPrediction(0))->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param array $predictions
     * @expectedException \Zeeml\Algorithms\Exceptions\MissingResultException
     */
    public function test_calculate_exception_with_slope_no_intercept(array $dataSet, array $predictions)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $formulaResults = new FormulasResults();

        $mean = (new Mean())->using($dataSet)->calculate();
        $formulaResults->save($mean);

        $slope = (new SimpleLinearSlope())
            ->using($dataSet)
            ->knowing($formulaResults)
            ->calculate();

        $formulaResults->save($slope);

        foreach ($dataSet as $instance) {
            (new SimpleLinearPrediction($instance->dimension(0)))
                ->knowing($formulaResults)
                ->calculate();
        }


    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     */
    public function test_calculate(array $dataSet, array $predictions)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0], [1]));

        $formulaResults = new FormulasResults();

        $mean = (new Mean())->using($dataSet)->calculate();
        $formulaResults->save($mean);

        $slope = (new SimpleLinearSlope())
            ->using($dataSet)
            ->knowing($formulaResults)
            ->calculate();
        $formulaResults->save($slope);
        echo $slope->getResult(), "\n";

        $intercept = (new SimpleLinearIntercept())
            ->using($dataSet)
            ->knowing($formulaResults)
            ->calculate();
        $formulaResults->save($intercept);

        foreach ($dataSet as $index => $instance) {
            $prediction = (new SimpleLinearPrediction($instance->dimension(0)))
                ->using($dataSet)
                ->knowing($formulaResults)
                ->calculate()
            ;

            $this->assertEquals($prediction->getResult(), $predictions[$index]);
        }
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
                [1.2, 2, 3.6, 2.8, 4.4]
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
                [50.1, 55.1, 60.1, 65.1, 70.1, 75.1, 80.1, 85.1, 90.1, 95.1, 100.1, 105.1, 110.1, 115.1, 120.1, 125.1]
            ]
        ];
    }
}


