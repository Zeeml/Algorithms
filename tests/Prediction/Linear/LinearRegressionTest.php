<?php

namespace Zeeml\Algorithms\Tests\Prediction\Linear;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Prediction\Linear\LinearRegression;
use Zeeml\Algorithms\Prediction\Linear\MultipleLinearRegression;
use Zeeml\Algorithms\Prediction\Prediction;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

/**
 * Class LinearRegressionTest
 */
class LinearRegressionTest extends TestCase
{
    /**
     * @dataProvider getData
     * @param array $data
     * @param array $dims
     * @param array $outputs
     * @param array $coefficients
     * @param array $predictions
     */
    public function testFit(array $data, array $dims, array $outputs, array $coefficients, array $predictions)
    {
        $dataSet = DataSetFactory::create($data);
        $dataSet->prepare(new Mapper($dims, $outputs));

        $linearRegression = new LinearRegression();
        $linearRegression->fit($dataSet);
        $this->assertEquals($linearRegression->getCoefficients(), $coefficients);
    }

    /**
     * @dataProvider getData
     * @param array $data
     * @param array $dims
     * @param array $outputs
     * @param array $coefficients
     * @param array $predictions
     * @expectedException \Zeeml\Algorithms\Exceptions\WrongUsageException
     */
    public function test_test_before_fit(array $data, array $dims, array $outputs, array $coefficients, array $predictions)
    {
        $dataSet = DataSetFactory::create($data);
        $dataSet->prepare(new Mapper($dims, $outputs));

        $linearRegression = new LinearRegression();
        $linearRegression->test($dataSet);
    }

    /**
     * @dataProvider getData
     * @param array $data
     * @param array $dims
     * @param array $outputs
     * @param array $coefficients
     * @param array $predictions
     * @param float $accuracy
     * @param float $rmse
     */
    public function testTest(array $data, array $dims, array $outputs, array $coefficients, array $predictions, float $accuracy, float $rmse)
    {
        $dataSet = DataSetFactory::create($data);
        $dataSet->prepare(new Mapper($dims, $outputs));

        $linearRegression = new LinearRegression();
        $linearRegression->fit($dataSet);
        $linearRegression->test($dataSet);

        $this->assertEquals($linearRegression->getCoefficients(), $coefficients);
        $this->assertEquals($linearRegression->getAccuracy(), $accuracy);
        $this->assertEquals($linearRegression->getRmse(), $rmse);

        foreach ($dataSet as $index => $instance) {
            $this->assertEquals($instance->getResult(LinearRegression::class), ['type' => Prediction::PREDICTION, 'result' => $predictions[$index]]);
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
                [0],
                [1],
                [0.4, 0.8],
                [1.2, 2, 3.6, 2.8, 4.4],
                0,
                0.692820323
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
                [0],
                [1],
                [0.1, 0.5],
                [50.1, 55.1, 60.1, 65.1, 70.1, 75.1, 80.1, 85.1, 90.1, 95.1, 100.1, 105.1, 110.1, 115.1, 120.1, 125.1],
                1,
                0,
            ],
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
                [0, 1],
                [2],
                [-152.76956142113, 1.2575168806525, 12.029457820725],
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
                ],
                0,
                4.8833069171680128
            ],
        ];
    }
}
