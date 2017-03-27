<?php

namespace Zeeml\Algorithms\Algorithms\Traits;

use Zeeml\Algorithms\Exceptions\EmptyDatasetException;
use Zeeml\Algorithms\Exceptions\IndexNotFoundException;
use Zeeml\Dataset\Dataset;
use Zeeml\Dataset\DatasetInterface;

/**
 * trait LinearPredictionCalculator
 * @package Zeeml\Algorithms\Algorithms\Traits
 */
trait PredictionCalculator
{
    protected $prediction;

    /**
     * calculates the prediction for a linear regression following the formula :
     * prediction = intercept + slope * input
     * @param float $input
     * @param float $intercept
     * @param float $slope
     * @return float
     */
    public function linearPrediction(float $input, float $intercept, float $slope): float
    {
        $this->prediction = $intercept + $slope * $input;

        return $this->prediction;
    }

    /**
     * calculates the prediction for a logistic regression following the formula :
     *                          1
     * prediction =    ---------------------
     *                 1 - EXP(-(bo+b1x1+b2x2-...))
     *
     * array slopes and array inputs having same indexes will be matches as slope[0]*input[0]
     *
     * @param float $intercept
     * @param array $slopes an array of all the slopes
     * @param array $inputs an array of all inputs
     * @return float
     */
    public function logisticPrediction(float $intercept, array $slopes, array $inputs)
    {
        $total = $intercept + array_sum(
            array_map(
                function($slope, $input) {
                    return $slope * $input;
                },
                $slopes,
                $inputs
            )
        );

        $this->prediction = 1 / 1 - exp(-$total);
    }

    /**
     * returns the prediction
     * @return array
     */
    public function getPrediction(): float
    {
        return $this->prediction;
    }

    public function reset()
    {
        $this->prediction = 0;
    }
}