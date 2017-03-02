<?php

use Zeeml\Algorithms\Adapter\LinearRegressionAdapter;
use PHPUnit\Framework\TestCase;

/**
 * LinearRegressionAdapter test case.
 */
class LinearRegressionAdapterTest extends TestCase
{

    /**
     *
     * @var LinearRegressionAdapter
     */
    private $linearRegressionAdapter;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated LinearRegressionAdapterTest::setUp()
        
        $this->linearRegressionAdapter = new LinearRegressionAdapter(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated LinearRegressionAdapterTest::tearDown()
        $this->linearRegressionAdapter = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
}

