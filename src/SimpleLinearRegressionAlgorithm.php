<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Traits\MeanCalculator;

/**
 * Class SimpleLinearRegressionAlgorithm
 * class that trains an array dataset following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
class SimpleLinearRegressionAlgorithm extends AbstractAlgorithms
{
    use MeanCalculator {
        MeanCalculator::reset as resetMeans;
    }

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Train the dataset following the Simple Linear Regression Algorithm and calculates the slope and intercept
     * @param array $dataset
     * @param float $learningRate
     * @return AlgorithmsInterface
     */
    public function fit(array $dataset, float $learningRate = 0.0): AlgorithmsInterface
    {
        $means = $this->calculateMeans($dataset);
        $this->calculateSlopeDataset($dataset, 0, 0, $means));
        $this->calculateIntercept($this->getMeanOutputAt(0), $this->getSlope(), $this->getMeanInputAt(0));

        return $this;
    }

    /**
     * function that tests the dataset
     * @param DatasetInterface $dataset
     * @return float
     */
    public function test(DatasetInterface $dataset)
    {
        $this->calculatescore($dataset, $this->getMeanOutputAt(0));
        $this->calculateRmse($dataset, $this->getMeanOutputAt(0));
    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function process($input)
    {
        return $this->predict($input, $this->getIntercept(), $this->getSlope());
    }

    public function reset()
    {
        $this->resetMeans();
        $this->resetMinMax();
        $this->resetSlope();
        $this->resetIntercept();
        $this->resetPrediction();
        $this->resetScore();
        $this->resetRmse();
    }
}
