<?php

use Zeeml\Algorithms\Dataset;
use PHPUnit\Framework\TestCase;

/**
 * Dataset test case.
 */
class DatasetTest extends TestCase
{

    /**
     *
     * @var Dataset
     */
    private $dataset;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->dataset = new Dataset(__DIR__ . '/fixtures/LinearRegressionExample.csv');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->dataset = null;
        
        parent::tearDown();
    }

    /**
     * Tests Dataset->read()
     */
    public function testRead()
    {
        $this->dataset->read();
    }

    /**
     * Tests Dataset->getData()
     */
    public function testGetData()
    {
        $this->assertInternalType('array', $this->dataset->read()->getData());
        $this->assertEquals(16, count($this->dataset->getData()));
    }
}
