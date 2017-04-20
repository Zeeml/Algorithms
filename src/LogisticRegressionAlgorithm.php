<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Traits\InterceptCalculator;
use Zeeml\Algorithms\Traits\InterceptsHistory;
use Zeeml\Algorithms\Traits\MeanCalculator;
use Zeeml\Algorithms\Traits\PredictionCalculator;
use Zeeml\Algorithms\Traits\RmseCalculator;
use Zeeml\Algorithms\Traits\SlopeCalculator;
use Zeeml\Algorithms\Traits\SlopesHistory;

/**
 * Class LogisticRegressionAlgorithm
 * class that trains a set of data following the Logistic Regression method
 * @package Zeeml\Algorithms\Adapter
 */
class LogisticRegressionAlgorithm extends AbstractAlgorithms
{
    use InterceptCalculator, PredictionCalculator  {
        InterceptCalculator::calculateIntercept1 as calculateIntercept;
        PredictionCalculator::logisticPrediction as predict;
    }

    use InterceptsHistory;
    use SlopesHistory;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * * Train the dataset following the logistic Regression Algorithm
     *
     *                           1
     * Prediction =   ----------------------
     *                1 + EXP(-(B0+B1×X1+B2×X2))
     *
     * @param DatasetInterface $dataset
     * @param float $learningRate
     * @param AlgorithmsInterface|null $previous
     * @return AlgorithmsInterface
     */
    public function fit(array $dataset, float $learningRate = 0.0, float $interceptStart = 0, float $slopeStart = 0): AlgorithmsInterface
    {
        $this->interceptsHistory[] = $this->intercept = $interceptStart;
        $this->slopesHistory[] = $this->slope = $slopeStart;
        $this->predictionErrorsHistory[] = null;

        foreach ($dataset as $row) {
            //calculate the prediction
            $this->predict($this->getIntercept(), [$this->getSlope1(), $this->getSlope2()], $instance->getInputs());
            //calculate the new intercept
            $this->calculateIntercept($this->getIntercept(), $learningRate, $instance->getOutputs()[0], $this->getPrediction());
            //calculate slope1
            $this->slope1 = $this->slope1 + $learningRate * ($instance->getOutputs()[0] - $this->getPrediction()) * $this->getPrediction() * (1 - $this->getPrediction()) * $instance->getInputs()[0];
            //calculate slope2
            $this->slope2 = $this->slope2 + $learningRate * ($instance->getOutputs()[0] - $this->getPrediction()) * $this->getPrediction() * (1 - $this->getPrediction()) * $instance->getInputs()[1];

            //historise everything
            $this->interceptsHistory[] = $this->intercept;
            $this->slope1History[] = $this->slope1;
            $this->slope2History[] = $this->slope2;
            $this->predictionHistory[] = $this->getPrediction();
        }

        //calculate the prediction using the latest intercept/slopes and add to history
        $this->predict($this->getIntercept(), [$this->getSlope1(), $this->getSlope2()], $instance->getInputs());
        $this->predictionHistory[] = $this->getPrediction();
    }

    /**
     * function that tests the dataset
     * @param DatasetInterface $dataset
     * @return float
     */
    public function test(DatasetInterface $dataset): float
    {

    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function process($input)
    {

    }

    public function getSlope1()
    {
        return $this->slope1;
    }

    public function getSlope2()
    {
        return $this->slope2;
    }

    public function reset()
    {
        $this->resetIntercept();
        $this->slope1 = 0;
        $this->slope2 = 0;
        $this->resetPrediction();
        $this->interceptsHistory = [];
        $this->slope1History = [];
        $this->slope2History = [];
        $this->predictionHistory = [];
    }
}
