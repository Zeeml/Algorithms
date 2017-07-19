<?php

namespace Zeeml\Algorithms\Tests\Formulas;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\MultipleLinearCoefficients;
use Zeeml\Algorithms\Formulas\MultipleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

class MultipleLinearPredictionTest extends TestCase
{
    /**
     * @expectedException \Zeeml\Algorithms\Exceptions\WrongUsageException
     */
    public function test_calculate_inputs_are_not_all_numeric()
    {
        (new MultipleLinearCoefficients([1, 'B', [2]]))->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param array $coeffs
     * @expectedException \Zeeml\Algorithms\Exceptions\MissingResultException
     */
    public function test_calculate_without_coeffs(array $dataSet, array $coeffs)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0, 1], [2]));

        $multiPrediction = (new MultipleLinearPrediction([41.9, 29.1]))->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param array $coeffs
     * @expectedException \Zeeml\Algorithms\Exceptions\WrongUsageException
     */
    public function test_calculate_wrong_number_of_inputs(array $dataSet, array $coeffs)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0, 1], [2]));

        $multiLinearCoeff = (new MultipleLinearCoefficients())
            ->using($dataSet)
            ->calculate()
        ;

        $formulaResults = new FormulasResults();
        $formulaResults->save($multiLinearCoeff);

        $multiPrediction = (new MultipleLinearPrediction([41.9, 29.1, 251.3]))->knowing($formulaResults)->calculate();
    }

    /**
     * @dataProvider getData
     * @param array $dataSet
     * @param array $coeffs
     */
    public function test_calculate(array $dataSet, array $predictions)
    {
        $dataSet = DataSetFactory::create($dataSet);
        $dataSet->prepare(new Mapper([0, 1], [2]));

        $multiLinearCoeff = (new MultipleLinearCoefficients())
            ->using($dataSet)
            ->calculate()
        ;

        $formulaResults = new FormulasResults();
        $formulaResults->save($multiLinearCoeff);

        foreach ($dataSet as $index => $instance) {
            $multiPrediction = (new MultipleLinearPrediction($instance->dimensions()))->knowing($formulaResults)->calculate();
            $this->assertEquals($multiPrediction->getResult(), $predictions[$index]);

        }
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
                [
                    249.97761846131,
                    254.26978534643,
                    257.3044353509,
                    260.46483704344,
                    266.39177587341,
                    271.45506237783,
                    274.36396069424,
                    279.66214108388,
                    284.13463075565,
                    285.84058328999,
                    297.4595670647,
                    300.24271369305,
                    310.82246498143,
                    311.77390738737,
                    322.78548483854,
                    335.01661756267,
                    340.83441419549,
                ]
            ],
        ];
    }
}
