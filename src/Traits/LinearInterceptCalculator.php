<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait InterceptCalculator that calculates an intercept
 * @package Zeeml\Algorithms\Traits
 */
trait InterceptCalculator
{
    protected $intercept = 0;

    /**
     * Calculating the intercept following the formula:
     *   intercept = mean(y) − slope × mean(x)
     * @param float $meanOutput
     * @param float $slope
     * @param float $meanInput
     */
    protected function calculateLinearIntercept(float $meanOutput, float $slope, float $meanInput)
    {
        $this->intercept = $meanOutput - ($slope * $meanInput);
    }

    /**
     *  Calculating the intercept following the formula:
     *
     *  intercept = intercept - $learningRate * $error
     *
     * @param float $previousIntercept
     * @param float $learningRate
     * @param float $error
     */
    protected function calculate2(float $previousIntercept, float $learningRate, float $error)
    {
        $this->intercept = $previousIntercept - ($learningRate * $error);
    }

    /**
     * Calculating the intercept following the formula:
     *
     *   intercept = intercept + learningRate × (y − prediction) × prediction × (1 − prediction)
     *
     * @param float $param1
     * @param float $param2
     * @param float $param3
     * @return bool
     */
    protected function calculate3(float $previousIntercept, float $learningRate, float $output, float $prediction)
    {
        $this->intercept = $previousIntercept + $learningRate * ($output - $prediction) * $prediction * (1 - $prediction);
    }

    /**
     * returns the intercept
     * @return float
     */
    protected function getIntercept(): float
    {
        return $this->intercept;
    }

    /**
     * resets the interceptCalculator by setting the intercept to 0
     */
    protected function reset()
    {
        $this->intercept = 0;
    }
}