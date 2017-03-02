<?php

use Zeeml\Algorithms\Adapter\LinearRegressionAdapter;

/**
 * LinearRegressionAdapter test case.
 */
class LinearRegressionAdapterTest extends PHPUnit_Framework_TestCase
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

