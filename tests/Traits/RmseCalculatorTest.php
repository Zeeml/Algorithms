<?php

namespace Zeeml\Algorithms\Traits;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Exceptions\MissingMethodException;

class RmseCalculatorTest extends TestCase
{
    protected $class1;
    protected $class2;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->class1 = new class() { use RmseCalculator; };
        $this->class2 = new class() {
            use RmseCalculator;

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

    public function testCalculateRmseFail()
    {
        $data = [
            [[1], [1]],
            [[2], [3]],
            [[4], [3]],
            [[3], [2]],
            [[5], [5]],
        ];

        $this->expectException(MissingMethodException::class);
        $this->class1->calculateRmse($data);
    }

    public function testCalculateRmse()
    {
        $data = [
            [[1], [1]],
            [[2], [3]],
            [[4], [3]],
            [[3], [2]],
            [[5], [5]],
        ];

        $this->class2->calculateRmse($data);
        $this->assertEquals($this->class2->getRmse(), 0.69282032302755081);
    }

    public function testResetRmse()
    {
        $this->class2->resetRmse();
        $this->assertEquals($this->class2->getRmse(), 0);
    }

}
