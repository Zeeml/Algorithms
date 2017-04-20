<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Traits\MeanCalculator;
use Zeeml\Algorithms\Traits\InterceptCalculator;
use Zeeml\Algorithms\Traits\SlopeCalculator;
use Zeeml\Algorithms\Traits\PredictionCalculator;
use Zeeml\Algorithms\Traits\ScoreCalculator;
use Zeeml\Algorithms\Traits\RmseCalculator;

/**
 * Class SimpleLinearRegressionAlgorithm
 * class that trains an array dataset following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
class SimpleLinearRegressionAlgorithm extends AbstractAlgorithms
{
    use MeanCalculator,  InterceptCalculator, SlopeCalculator, PredictionCalculator, ScoreCalculator, RmseCalculator {
        InterceptCalculator::calculateIntercept2 as calculateIntercept;
        SlopeCalculator::calculateSlope2 as calculateSlope;
        PredictionCalculator::linearPrediction as predict;
    }

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Trains the dataset following the Simple Linear Regression Algorithm and calculates the slope and intercept
     * @param array $dataset
     * @param float $learningRate
     * @return AlgorithmsInterface
     */
    public function fit(array $dataset, float $learningRate = 0.0): AlgorithmsInterface
    {
        $means = $this->calculateMeans($dataset);
        $this->calculateSlope($dataset, $means[0][0], $means[1][0], 0);
        $this->calculateIntercept($means[1][0], $this->getSlope(0), $means[0][0]);

        return $this;
    }

    /**
     * function that tests the dataset by calculating the score and the rmse
     * @param array $dataset
     * @return float
     */
    public function test(array $dataset)
    {
        $this->calculateScore($dataset, $this->means[1][0]);
        $this->calculateRmse($dataset, $this->means[1][0]);
    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function process($input)
    {
        return $this->predict($input, $this->getIntercept(), $this->getSlope(0));
    }

    public function reset()
    {
        $this->resetMeans();
        $this->resetSlopes();
        $this->resetIntercept();
        $this->resetScore();
        $this->resetRmse();
        $this->resetPrediction();
    }
}
