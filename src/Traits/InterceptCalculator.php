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
     * intercept = intercept + learningRate × (y − prediction) × prediction × (1 − prediction)
     * @param float $previousIntercept
     * @param float $learningRate
     * @param float $output
     * @param float $prediction
     */
    public function calculateIntercept1(float $previousIntercept, float $learningRate, float $output, float $prediction)
    {
        $this->intercept = $previousIntercept + $learningRate * ($output - $prediction) * $prediction * (1 - $prediction);
    }

    /**
     *  Calculating the intercept following the formula:
     *
     *  intercept = a - b * c
     *
     * @param float $a
     * @param float $b
     * @param float $c
     */
    public function calculateIntercept2(float $a, float $b, float $c)
    {
        $this->intercept = $a - ($b * $c);
    }

    /**
     * returns the intercept
     * @return float
     */
    public function getIntercept(): float
    {
        return $this->intercept;
    }

    /**
     * resets the interceptCalculator by setting the intercept to 0
     */
    public function resetIntercept()
    {
        $this->intercept = 0;
    }
}