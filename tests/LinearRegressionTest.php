<?php

use \Zeeml\Algorithms\Prediction\LinearRegression;
use Zeeml\Dataset\Dataset;
use PHPUnit\Framework\TestCase;

/**
 * Class LinearRegressionTest
 */
class LinearRegressionTest extends TestCase
{
    protected $linearRegression;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $dataset = Dataset::factory(__DIR__ . '/fixtures/LinearRegressionExample.csv', Dataset::PREDICTION);
        $dataset->processor()->populate();
        $this->linearRegression = new LinearRegression($dataset);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->linearRegression = null;

        parent::tearDown();
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $linearRegression->prepare()
     */
    public function testPrepare()
    {
        $this->linearRegression->prepare();
        $this->assertTrue(count($this->linearRegression->getDataset()->instances()[0]->inputs()) == 1);
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $linearRegression->prepare()
     */
    public function testTrain()
    {
        $this->linearRegression->prepare();
        $this->linearRegression->train();
        $this->assertEquals(round($this->linearRegression->getIntercept(), 2), 0.1);
        $this->assertEquals(round($this->linearRegression->getSlope(), 2), 0.5);
    }

    /**
     * Tests the prepare function that prepares the dataset
     * $linearRegression->prepare()
     */
    public function testPredict()
    {
        $this->linearRegression->prepare();
        $this->linearRegression->train();
        $this->assertEquals($this->linearRegression->predict(100), 50.1);
    }

}
