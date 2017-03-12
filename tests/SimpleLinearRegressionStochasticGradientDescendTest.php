<?php

use \Zeeml\Algorithms\Prediction\SimpleLinearRegression;
use Zeeml\Dataset\Dataset;
use PHPUnit\Framework\TestCase;

/**
 * Class LinearRegressionTest
 */
use \Zeeml\Algorithms\Prediction\SimpleLinearRegressionStochasticGradientDescend;

class SimpleLinearRegressionStochasticGradientDescendTest extends TestCase
{
    protected $sLinearRegressionStochastic;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $dataset = Dataset::factory(__DIR__ . '/fixtures/LinearRegressionStochasticExample.csv', Dataset::PREDICTION);
        $dataset->processor()->populate();
        $this->sLinearRegressionStochastic = new SimpleLinearRegressionStochasticGradientDescend($dataset);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->sLinearRegressionStochastic = null;

        parent::tearDown();
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $simpleLinearRegression->prepare()
     */
    public function testPrepare()
    {
        $this->sLinearRegressionStochastic->prepare();
        $this->assertTrue(count($this->sLinearRegressionStochastic->getDataset()->instances()[0]->inputs()) == 1);
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $simpleLinearRegression->prepare()
     */
    public function testTrain()
    {
        $this->sLinearRegressionStochastic->prepare();
        $this->sLinearRegressionStochastic->setEpochs(4);
        $this->sLinearRegressionStochastic->setLearningRate(0.01);
        $this->sLinearRegressionStochastic->train();
        print_r($this->sLinearRegressionStochastic);exit;
        $this->assertEquals(round($this->simpleLinearRegression->getIntercept(), 2), 0.1);
        $this->assertEquals(round($this->simpleLinearRegression->getSlope(), 2), 0.5);
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $simpleLinearRegression->prepare()
     */
    public function testPredict()
    {
        $this->simpleLinearRegression->prepare();
        $this->simpleLinearRegression->train();
        $this->assertEquals($this->simpleLinearRegression->predict(100), 50.1);
    }

}
