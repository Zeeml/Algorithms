<?php

use Zeeml\Algorithms\SimpleLinearRegressionAlgorithm;
use PHPUnit\Framework\TestCase;

/**
 * Class LinearRegressionTest
 */
class SimpleLinearRegressionAlgorithmTest extends TestCase
{
    protected $simpleLinearRegression;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->simpleLinearRegression = new SimpleLinearRegressionAlgorithm();
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
    public function testFit()
    {
        $data = [
            [ [1], [1]],
            [ [2], [3]],
            [ [4], [3]],
            [ [3], [2]],
            [ [5], [5]],
        ];

        $this->simpleLinearRegression->fit($data);
        $this->assertEquals(round($this->simpleLinearRegression->getIntercept(), 2), 0.4);
        $this->assertEquals(round($this->simpleLinearRegression->getSlope(0), 2), 0.8);
    }

    /**
     *
     */
    public function testTest()
    {
        $data = [
            [ [1], [1]],
            [ [2], [3]],
            [ [4], [3]],
            [ [3], [2]],
            [ [5], [5]],
        ];

        $this->simpleLinearRegression->fit($data);
        $this->simpleLinearRegression->test($data);
        $this->assertEquals($this->simpleLinearRegression->getScore(), 0.72727272727273);
        $this->assertEquals($this->simpleLinearRegression->getRmse(), 0.692820323);
    }

}
