<?php

namespace Zeeml\Algorithms\Traits;

use PHPUnit\Framework\TestCase;

class InterceptCalculatorTest extends TestCase
{
    protected $class;
    /**
    * Prepares the environment before running a test.
    */
    protected function setUp()
    {
        parent::setUp();
        $this->class = new class() { use InterceptCalculator; };
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->class = null;
        parent::tearDown();
    }

    public function testCalculateIntercept1()
    {
        //method1(float $previousIntercept, float $learningRate, float $output, float $prediction)
        $this->class->calculateIntercept1(5, 0.1, 2, 2);
        $this->assertEquals($this->class->getIntercept(), 5);
    }

    public function testCalculateIntercept2()
    {
        $this->class->calculateIntercept2(7, 2, 3);
        $this->assertEquals($this->class->getIntercept(), 1);
    }

    public function testResetIntercept()
    {
        $this->class->resetIntercept();
        $this->assertEquals($this->class->getIntercept(), 0);
    }
}
