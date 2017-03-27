<?php

namespace Zeeml\Algorithms\Algorithms;

use Zeeml\Algorithms\Algorithms\Traits\InterceptCalculator;
use Zeeml\Algorithms\Algorithms\Traits\PredictionCalculator;
use Zeeml\Algorithms\Algorithms\Traits\LinearRegressionScore;
use Zeeml\Algorithms\Algorithms\Traits\MeanCalculator;
use Zeeml\Algorithms\Algorithms\Traits\MinMaxCalculator;
use Zeeml\Algorithms\Algorithms\Traits\RmseCalculator;
use Zeeml\Algorithms\Algorithms\Traits\SlopeCalculator;
use Zeeml\Dataset\DatasetInterface;

/**
 * Class LinearRegression
 * class that trains a set of data following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
class SimpleLinearRegressionAlgorithm extends AbstractAlgorithms
{
    use MeanCalculator, MinMaxCalculator, SlopeCalculator, InterceptCalculator, LinearRegressionScore, PredictionCalculator, RmseCalculator {
        MeanCalculator::reset as resetMeans;
        SlopeCalculator::reset as resetSlope;
        InterceptCalculator::reset as resetIntercept;
        InterceptCalculator::calculate1 as calculateIntercept;
        PredictionCalculator::reset as resetPrediction;
        PredictionCalculator::linearPrediction as predict;
        LinearRegressionScore::reset as resetScore;
        RmseCalculator::reset as resetRmse;
        MinMaxCalculator::reset as resetMinMax;
    }

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Train the dataset following the Simple Linear Regression Algorithm and calculates the slope and intercept
     * @param DatasetInterface $dataset
     * @param float $learningRate
     * @param AlgorithmsInterface|null $previous
     * @return AlgorithmsInterface
     */
    public function train(DatasetInterface $dataset, float $learningRate = 0.0, AlgorithmsInterface $previous = null): AlgorithmsInterface
    {
        $this->calculateMeans($dataset);
        $this->calculateSlopeDataset($dataset, 0, 0, $this->getMeanInputAt(0), $this->getMeanOutputAt(0));
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
