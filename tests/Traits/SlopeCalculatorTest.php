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

    public function testCalculateSlope2BigData()
    {
        $data = array_pad([], 100000, [ array_pad([], 1000, 1), array_pad([], 1000, 2) ]);
        $this->class->calculateSlope2($data, 1, 2);
        $this->assertEquals($this->class->getSlope(0), 0);
    }

    public function testCalculateSlope2()
    {
        $data = [
            [[1, 2], [1]],
            [[2, 3], [3]],
            [[4, 4], [3]],
            [[3, 5], [2]],
            [[5, 4], [5]],
        ];

        $this->class->calculateSlope2($data, 3, 2.8, 0);
        $this->assertEquals($this->class->getSlope(0), 0.8);
        $this->class->calculateSlope2($data, 3.6, 2.8, 1);
        $this->assertEquals($this->class->getSlope(1), 0.22033898305084748);

        $this->assertEquals($this->class->getSlopes(), [0.8, 0.22033898305084748]);

    }

    public function testCalculateSlope1()
    {
        $this->class->calculateSlope1(1, 0.1, 2, 0);
        $this->assertEquals($this->class->getSlope(0), -0.2);
        $this->class->calculateSlope1(1, 0.1, 2, 1);
        $this->class->calculateSlope1(1, 0.1, 2, 1);
        $this->assertEquals($this->class->getSlope(1), -0.4);

        $this->assertEquals($this->class->getSlopes(), [-0.2, -0.4]);
    }

    public function testResetSlopes()
    {
        $this->class->resetSlopes();
        $this->assertEquals($this->class->getSlopes(), []);
    }

    public function testResetSlope()
    {
        $this->class->resetSlope(0);
        $this->assertEquals($this->class->getSlope(0), 0);
    }
}
