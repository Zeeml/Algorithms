<?php

namespace Zeeml\Algorithms\Prediction;

/**
 * Class LinearRegression
 * class that trains a set of data following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
class LinearRegression extends AbstracPrediction
{
    public function prepare(): PredictionInterface
    {
        //$this->isPrepared = true;
        //preparing the dataset by taking one input and one input
        $this->dataset->prepare(1, 1);

        return $this;
    }

    /**
     * functions that trains the data sent,
     * @return bool
     */
    public function train(): PredictionInterface
    {
        /*if (!$this->isPrepared) {
            $this->prepare();
        }*/
        $this->isTrained = true;
        //calculate the means of each input and eac (MeanCalculator)
        $this->calculateMeans($this->dataset);
        //based on both means, calculate the slope
        $this->calculateSlope($this->dataset, 0, 0, $this->getMeanInputAt(0), $this->getMeanOutputAt(0));
        //And calculate the intercept
        $this->calculateIntercept($this->getSlope(), $this->getMeanInputAt(0), $this->getMeanOutputAt(0));
        //update the dataset with all the calculated info
        return $this;
    }

    public function updateDataset()
    {
        foreach ($this->dataset as $instance) {
            $instance->result(
                [
                    'LinearRegression' => [
                        'meanInputs'  => $this->getMeanInputs(),
                        'meanOutputs' => $this->getMeanOutputs(),
                        'prediction'  => $this->predict($instance->inputs()[0]),
                    ]
                ]
            );
        }
    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function predict($input): float
    {
        return $this->getIntercept() + $this->getSlope() * $input;
    }
}
