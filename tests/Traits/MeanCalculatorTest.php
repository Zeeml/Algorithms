<?php

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Traits\MeanCalculator;
use Kanel\Timer\Timer;

/**
 * Class LinearRegressionTest
 */
class MeanCalculatorTest extends TestCase
{
    protected $class;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->class = new class() { use MeanCalculator; };
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->class = null;
        parent::tearDown();
    }

    public function testCalculateMeansBigData()
    {
        $data = array_pad([], 100000, [ array_pad([], 10, 1), array_pad([], 10, 2) ]);
        $means = $this->class->calculateMeans($data);
        $this->assertTrue(is_array($means));
        $this->assertEquals($means, [ array_pad([], 10, 1), array_pad([], 10, 2) ]);
    }

    public function testCalculateMeans()
    {
        $data = [
            [[1], [1]],
            [[2], [3]],
            [[4], [3]],
            [[3], [2]],
            [[5], [5]],
        ];
        $means = $this->class->calculateMeans($data);
        $this->assertTrue(is_array($means));
        $this->assertEquals($means, [ [3], [2.8] ]);
    }
}
