<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Traits\InterceptCalculator;
use Zeeml\Algorithms\Traits\MeanCalculator;
use Zeeml\Algorithms\Traits\PredictionCalculator;
use Zeeml\Algorithms\Traits\RmseCalculator;
use Zeeml\Algorithms\Traits\SlopeCalculator;

/**
 * Class LogisticRegressionAlgorithm
 * class that trains a set of data following the Logistic Regression method
 * @package Zeeml\Algorithms\Adapter
 */
class LogisticRegressionAlgorithm extends AbstractAlgorithms
{
    use InterceptCalculator, PredictionCalculator {
        InterceptCalculator::reset as resetIntercept;
        InterceptCalculator::calculate3 as calculateIntercept;
        PredictionCalculator::reset as resetPrediction;
        PredictionCalculator::logisticPrediction as predict;
    }

    protected $interceptsHistory;
    protected $slope1History;
    protected $slope2History;
    protected $predictionHistory;

    protected $slope1;
    protected $slope2;

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
     *
     *
     * @param DatasetInterface $dataset
     * @param float $learningRate
     * @param AlgorithmsInterface|null $previous
     * @return AlgorithmsInterface
     */
    public function train(array $dataset, float $learningRate = 0.0, AlgorithmsInterface $previous = null): AlgorithmsInterface
    {
        //if a previous algorithm was used to train the dataset
        if ($previous) {
            //use the last values as the new intercept/slope1/slope2
            $this->intercept = $previous->getIntercept();
            $this->slope1 = $previous->getSlope1();
            $this->slope2 = $previous->getSlope2();
        }
        //If no previous intercept/slope1/slope2/prediction = 0

        //add intercept and slopes to the history
        $this->interceptsHistory[] = $this->getIntercept();
        $this->slope1History[] = $this->slope1;
        $this->slope2History[] = $this->slope2;


        foreach ($dataset as $instance) {
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
