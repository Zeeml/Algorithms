<?php

namespace Zeeml\Algorithms\Traits;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Exceptions\MissingMethodException;

/**
 * trait RmseCalculator
 * @package Zeeml\Algorithms\Traits
 */
class ScoreCalculatorTest extends TestCase
{
    protected $class1;
    protected $class2;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->class1 = new class() { use ScoreCalculator; };
        $this->class2 = new class() {
            use ScoreCalculator;

            public function process($input)
            {
                switch ($input) {
                    case 1: return 1.2;
                    case 2: return 2;
                    case 4: return 3.6;
                    case 3: return 2.8;
                    case 5: return 4.4;
                }

                return $input;
            }
        };
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->class = null;
        parent::tearDown();
    }

    public function testCalculateScoreFail()
    {
        $data = [
            [[1], [1]],
            [[2], [3]],
            [[4], [3]],
            [[3], [2]],
            [[5], [5]],
        ];

        $this->expectException(MissingMethodException::class);
        $this->class1->calculateScore($data, 2.8);
    }

    public function testCalculateScore()
    {
        $data = [
            [[1], [1]],
            [[2], [3]],
            [[4], [3]],
            [[3], [2]],
            [[5], [5]],
        ];

        $this->class2->calculateScore($data, 2.8);
        $this->assertEquals($this->class2->getScore(), 0.72727272727272729);
    }

    public function testResetScore()
    {
        $this->class1->resetScore();
        $this->class2->resetScore();
        $this->assertEquals($this->class1->getScore(), 0);
        $this->assertEquals($this->class2->getScore(), 0);

    }
}
