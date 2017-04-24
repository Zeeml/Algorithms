<?php

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Traits\PredictionErrorCalculator;

class PredictionErrorCalculatorTest extends TestCase
{
    protected $class;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->class = new class() { use PredictionErrorCalculator; };
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->class = null;
        parent::tearDown();
    }

    public function testCalculateError()
    {
        $this->class->calculateError(3, 2);
        $this->assertEquals($this->class->getPredictionError(), 1);
        $this->class->calculateError(3.8765, 1.787);
        $this->assertEquals($this->class->getPredictionError(), 2.0895);
    }

    public function testResetPredictionError()
    {
        $this->class->resetPredictionError();
        $this->assertEquals($this->class->getPredictionError(), 0);
    }
}