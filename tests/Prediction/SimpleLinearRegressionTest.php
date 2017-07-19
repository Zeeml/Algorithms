<?php

namespace Zeeml\Algorithms\Tests\Prediction\Linear;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Prediction\Linear\SimpleLinearRegression;
use Zeeml\DataSet\DataSet\Mapper;
use Zeeml\DataSet\DataSetFactory;

/**
 * Class LinearRegressionTest
 */
class SimpleLinearRegressionTest extends TestCase
{
    /**
     * @dataProvider getData
     * @param array $data
     * @param float $slope
     * @param float $intercept
     */
    public function testFit(array $data, float $slope, float $intercept)
    {
        $dataSet = DataSetFactory::create($data);
        $dataSet->prepare(new Mapper([0], [1]));

        $simpleLinearRegression = new SimpleLinearRegression();
        $simpleLinearRegression->fit($dataSet);

        $this->assertEquals($simpleLinearRegression->getSlope(), $slope);
        $this->assertEquals($simpleLinearRegression->getIntercept(), $intercept);
    }

    /**
     * @dataProvider getData
     * @param array $data
     * @param float $slope
     * @param float $intercept
     * @param array $predictions
     */
    public function testTest(array $data, float $slope, float $intercept, array $predictions)
    {
        $dataSet = DataSetFactory::create($data);
        $dataSet->prepare(new Mapper([0], [1]));

        $simpleLinearRegression = new SimpleLinearRegression();
        $simpleLinearRegression->fit($dataSet);
        $simpleLinearRegression->test($dataSet);

        $this->assertEquals($simpleLinearRegression->getSlope(), $slope);
        $this->assertEquals($simpleLinearRegression->getIntercept(), $intercept);

        foreach ($dataSet as $index => $instance) {
            $this->assertEquals($instance->result(SimpleLinearRegression::class), $predictions[$index]);
        }
    }

    /**
     * tests the prediction
     * @dataProvider getData
     * @param array $data
     * @param float $slope
     * @param float $intercept
     * @param array $predictions
     */
    public function testPredict(array $data, float $slope, float $intercept, array $predictions)
    {
        $dataSet = DataSetFactory::create($data);
        $dataSet->prepare(new Mapper([0], [1]));

        $simpleLinearRegression = new SimpleLinearRegression();
        $simpleLinearRegression->fit($dataSet);

        $this->assertEquals($simpleLinearRegression->getSlope(), $slope);
        $this->assertEquals($simpleLinearRegression->getIntercept(), $intercept);

        foreach ($dataSet as $index => $instance) {
            $this->assertEquals(
                $simpleLinearRegression->predict($instance->dimension(0)),
                $predictions[$index]
            );
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
                0.8,
                0.4,
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
                0.5,
                0.1,
                [50.1, 55.1, 60.1, 65.1, 70.1, 75.1, 80.1, 85.1, 90.1, 95.1, 100.1, 105.1, 110.1, 115.1, 120.1, 125.1]
            ]
        ];
    }
}
