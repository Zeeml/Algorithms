<?php

namespace Zeeml\Algorithms\Algorithms;

use Zeeml\Algorithms\Algorithms\Traits\InterceptCalculator;
use Zeeml\Algorithms\Algorithms\Traits\PredictionCalculator;
use Zeeml\Algorithms\Algorithms\Traits\LinearRegressionScore;
use Zeeml\Algorithms\Algorithms\Traits\MeanCalculator;
use Zeeml\Algorithms\Algorithms\Traits\PredictionErrorCalculator;
use Zeeml\Algorithms\Algorithms\Traits\RmseCalculator;
use Zeeml\Algorithms\Algorithms\Traits\SlopeCalculator;
use Zeeml\Dataset\DatasetInterface;

/**
 * Class SGDLinearRegressionAlgorithm
 * class that trains a set of data following the linear regression method using stochastic gradient descent
 * @package Zeeml\Algorithms\Adapter
 */
class SGDLinearRegressionAlgorithm extends AbstractAlgorithms
{
    use MeanCalculator, RmseCalculator, SlopeCalculator, InterceptCalculator, PredictionCalculator, PredictionErrorCalculator, LinearRegressionScore {
        RmseCalculator::reset as resetRmse;
        SlopeCalculator::reset as resetSlope;
        InterceptCalculator::reset as resetIntercept;
        InterceptCalculator::calculate2 as calculateIntercept;
        PredictionCalculator::reset as resetPrediction;
        PredictionCalculator::linearPrediction as predict;
        PredictionErrorCalculator::reset as resetError;
        LinearRegressionScore::reset as resetScore;

    }

    protected $slopesHistory;
    protected $interceptsHistory;
    protected $errorsHistory;

    /**
     * StochasticGradientDescentAlgorithm constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @param DatasetInterface $dataset
     * @param float $learningRate
     * @param AlgorithmsInterface $previous the previous algorithm used during the previsous epoch , null if first epoch
     * @return AlgorithmsInterface
     */
    public function train(DatasetInterface $dataset, float $learningRate = 0.0, AlgorithmsInterface $previous = null): AlgorithmsInterface
    {
        //The history starts off by the latest intercept and slope calculated, if first iteration it is equal to 0
        if ($previous) {
            $this->intercept = $previous->getIntercept();
            $this->slope = $previous->getSlope();
        }

        $this->interceptsHistory[] = $this->getIntercept();
        $this->slopesHistory[] = $this->getSlope();
        $this->errorsHistory[] = $this->getError();

        foreach ($dataset as $instance) {
            //Getting the input
            $input = $instance->inputs()[0];
            //Predicting the result based on the intercept/slope
            $this->predict($input, $this->getIntercept(), $this->getSlope());
            //calculating the error
            $this->calculateError($this->getPrediction(), $instance->outputs()[0]);
            //Calculating the new intercept based on the old one
            $this->calculateIntercept($this->getIntercept(), $learningRate, $this->getError());
            //Calculating the new slope based on the old one
            $this->calculateSlope($input, $learningRate, $this->getError());

            //archive the slope/intercept/error
            $this->interceptsHistory[] = $this->getIntercept();
            $this->slopesHistory[] = $this->getSlope();
            $this->errorsHistory[] = $this->getError();
        }

        return $this;
    }

    /**
     * @param DatasetInterface $dataset
     * @return float
     */
    public function test(DatasetInterface $dataset)
    {
        $this->calculateMeans($dataset);
        $this->calculateRmse($dataset);
        $this->calculatescore($dataset, $this->getMeanOutputAt(0));
    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function process($input)
    {
        return $this->intercept + $this->slope * $input;
    }

    public function reset()
    {
        $this->interceptsHistory = [];
        $this->slopesHistory = [];
        $this->errorsHistory = [];
        $this->resetRmse();
        $this->resetSlope();
        $this->resetIntercept();
        $this->resetPrediction();
        $this->resetError();
        $this->resetScore();
    }
}
