<?php

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\SGDLinearRegressionAlgorithm;

/**
 * Class LinearRegressionTest
 */

class SGDLinearRegressionAlgorithmTest extends TestCase
{
    protected $sgdLinearRegression;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sgdLinearRegression = new SGDLinearRegressionAlgorithm();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->sgdLinearRegression = null;

        parent::tearDown();
    }

    public function testFit()
    {
        $data = [
            [ [1], [1]],
            [ [2], [3]],
            [ [4], [3]],
            [ [3], [2]],
            [ [5], [5]],
        ];
        $this->sgdLinearRegression->fit($data, 0.01);
        $this->assertEquals(
            $this->sgdLinearRegression->getSlopesHistory(),
            [0, 0.01, 0.0694, 0.176708, 0.21880847, 0.410078328]
        );
        $this->assertEquals(
            $this->sgdLinearRegression->getInterceptsHistory(),
            [0, 0.01, 0.0397, 0.066527, 0.08056049, 0.1188144616]
        );
        $this->assertEquals(
            $this->sgdLinearRegression->getPredictionErrorsHistory(),
            [null, -1, -2.97, -2.6827, -1.403349, -3.82539716]
        );
    }

    public function testTest()
    {
        $data = [
            [ [1], [1]],
            [ [2], [3]],
            [ [4], [3]],
            [ [3], [2]],
            [ [5], [5]],
        ];
        $this->sgdLinearRegression->reset();
        for ($i = 0; $i < 4; $i ++) {
            $this->sgdLinearRegression->fit($data, 0.01, $this->sgdLinearRegression->getIntercept(), $this->sgdLinearRegression->getSlope(0));
        }
        $this->sgdLinearRegression->test($data);
        $this->assertEquals($this->sgdLinearRegression->getRmse(), 0.7206264014789554);
        $this->assertEquals($this->sgdLinearRegression->getScore(), 0.70494181221107466);
    }

    public function testProcess()
    {
        $data = [
            [ [1], [1]],
            [ [2], [3]],
            [ [4], [3]],
            [ [3], [2]],
            [ [5], [5]],
        ];
        $this->sgdLinearRegression->reset();
        for ($i = 0; $i < 4; $i ++) {
            $this->sgdLinearRegression->fit($data, 0.01, $this->sgdLinearRegression->getIntercept(), $this->sgdLinearRegression->getSlope(0));
        }

        $this->assertEquals($this->sgdLinearRegression->process(1), 1.0213361012275326);
        $this->assertEquals($this->sgdLinearRegression->process(2), 1.8117747114069398);
        $this->assertEquals($this->sgdLinearRegression->process(4), 3.3926519317657537);
        $this->assertEquals($this->sgdLinearRegression->process(3), 2.6022133215863468);
        $this->assertEquals($this->sgdLinearRegression->process(5), 4.183090542);
    }

    public function testReset()
    {
        $this->sgdLinearRegression->reset();
        $this->assertEquals($this->sgdLinearRegression->getInterceptsHistory(), []);
        $this->assertEquals($this->sgdLinearRegression->getSlopesHistory(), []);
        $this->assertEquals($this->sgdLinearRegression->getPredictionErrorsHistory(), []);
        $this->assertEquals($this->sgdLinearRegression->getRmse(), 0);
        $this->assertEquals($this->sgdLinearRegression->getSlopes(), []);
        $this->assertEquals($this->sgdLinearRegression->getIntercept(), 0);
        $this->assertEquals($this->sgdLinearRegression->getPrediction(), 0);
        $this->assertEquals($this->sgdLinearRegression->getPredictionError(), 0);
        $this->assertEquals($this->sgdLinearRegression->getScore(), 0);
    }

}
