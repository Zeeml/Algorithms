<?php

use \Zeeml\Algorithms\Prediction\SimpleLinearRegression;
use Zeeml\Dataset\Dataset;
use PHPUnit\Framework\TestCase;

/**
 * Class LinearRegressionTest
 */
class SimpleLinearRegressionTest extends TestCase
{
    protected $simpleLinearRegression;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $dataset = Dataset::factory(__DIR__ . '/fixtures/LinearRegressionExample.csv', Dataset::PREDICTION);
        $dataset->processor()->populate();
        $this->simpleLinearRegression = new SimpleLinearRegression($dataset);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->simpleLinearRegression = null;

        parent::tearDown();
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $simpleLinearRegression->prepare()
     */
    public function testPrepare()
    {
        $this->simpleLinearRegression->prepare();
        $this->assertTrue(count($this->simpleLinearRegression->getDataset()->instances()[0]->inputs()) == 1);
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $simpleLinearRegression->prepare()
     */
    public function testTrain()
    {
        $this->simpleLinearRegression->prepare();
        $this->simpleLinearRegression->train();
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
