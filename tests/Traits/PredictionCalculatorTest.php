<?php

namespace Zeeml\Algorithms\Traits;

use PHPUnit\Framework\TestCase;

/**
 * trait LinearPredictionCalculator
 * @package Zeeml\Algorithms\Traits
 */
class PredictionCalculatorTest extends TestCase
{
    protected $class;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->class = new class() { use PredictionCalculator; };
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->class = null;
        parent::tearDown();
    }

    public function testLinearPrediction()
    {
        $this->class->linearPrediction(1, 2, 3);
        $this->assertEquals($this->class->getPrediction(), 5);
    }

    public function testLogisticPredictionBigData()
    {
        $this->class->logisticPrediction(1, array_pad([], 100000, 2.8), array_pad([], 100000, 2));
        $this->assertEquals($this->class->getPrediction(), 1);
    }

    public function testLogisticPrediction()
    {
        $this->class->logisticPrediction(1, [1, 2], [3, 4]);
        $this->assertEquals($this->class->getPrediction(), 0.99999385578764666);
    }

    public function testResetPrediction()
    {
        $this->class->resetprediction();
        $this->assertEquals($this->class->getPrediction(), 0);
    }
}
