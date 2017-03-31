<?php

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Traits\SlopeCalculator;

/**
 * Class LinearRegressionTest
 */
class SlopeCalculatorTest extends TestCase
{
    protected $class;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->class = new class() { use SlopeCalculator; };
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->class = null;
        parent::tearDown();
    }

    public function testMethod1BigData()
    {
        $data = array_pad([], 100000, [ [1, 6, 9, 18, 6, 56], [78, 67] ]);
        $means = [ [1, 6, 9, 18, 6, 56], [78, 67] ];
        $this->class->method1($data, 0, 0, $means);
        $this->assertEquals($this->class->getSlope(), 0);
    }

    public function testMethod1()
    {
        $data = [
            [[1], [1]],
            [[2], [3]],
            [[4], [3]],
            [[3], [2]],
            [[5], [5]],
        ];
        $means = [ [3], [2.8] ];
        $this->class->method1($data, 0, 0, $means);
        $this->assertEquals($this->class->getSlope(), 0.8);
    }
}
