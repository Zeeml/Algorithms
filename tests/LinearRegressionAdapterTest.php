<?php

use Zeeml\Algorithms\Adapter\LinearRegressionAdapter;
use Zeeml\Algorithms\Dataset\CsvDataset;
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
    public function testPrepare()
    {
        $data = [[1, 2], [3, 4], [5, 6], [7, 8]];
        $this->linearRegressionAdapter = new LinearRegressionAdapter($data);
        $this->linearRegressionAdapter->prepare();
        $this->assertEquals($data, $this->linearRegressionAdapter->getTrainingData());

        $data = [[1, 2], [3, 4, 5], [6, 7], [8, 9]];
        $this->linearRegressionAdapter = new LinearRegressionAdapter($data);
        $this->linearRegressionAdapter->prepare();
        $this->assertEquals(
            json_encode([[1, 2], [6, 7], [8, 9]], JSON_FORCE_OBJECT),
            json_encode($this->linearRegressionAdapter->getTrainingData(), JSON_FORCE_OBJECT)
        );

    }

    /**
     * Constructs the test case.
     */
    public function testTrain()
    {

        $data = [[1, 1], [2, 3], [4, 3], [3, 2], [5, 5]];
        $this->linearRegressionAdapter = new LinearRegressionAdapter($data);
        $this->assertTrue($this->linearRegressionAdapter->train());
        $this->assertEquals($this->linearRegressionAdapter->getSlope(), 0.8);
        $this->assertEquals($this->linearRegressionAdapter->getIntercept(), 0.4);

        $dataset = new CsvDataset(__DIR__ . '/fixtures/LinearRegressionExample.csv');
        $dataset->read();
        $this->linearRegressionAdapter = new LinearRegressionAdapter($dataset->getData());
        $this->assertTrue($this->linearRegressionAdapter->train());
        $this->assertEquals(round($this->linearRegressionAdapter->getIntercept(), 2), 0.10);
        $this->assertEquals($this->linearRegressionAdapter->getSlope(), 0.5);
    }

    /**
     * Constructs the test case.
     */
    public function testPredict()
    {
        $data = [[1, 1], [2, 3], [4, 3], [3, 2], [5, 5]];
        $this->linearRegressionAdapter = new LinearRegressionAdapter($data);
        $this->linearRegressionAdapter->train();
        $this->assertEquals($this->linearRegressionAdapter->predict(1), 1.2);

        $dataset = new CsvDataset(__DIR__ . '/fixtures/LinearRegressionExample.csv');
        $dataset->read();
        $this->linearRegressionAdapter = new LinearRegressionAdapter($dataset->getData());
        $this->linearRegressionAdapter->train();
        $this->assertEquals(round($this->linearRegressionAdapter->predict(100), 2), 50.10);

    }
}
