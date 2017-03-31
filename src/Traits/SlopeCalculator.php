<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait SlopeCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait SlopeCalculator
{
    protected $slope;

    /**
     * Calculating the slope of the dataset following the formula:
     *               Σ(x - mean(x))(y - mean(y))
     *   slope =     ---------------------------
     *                     Σ(x - mean(x))²
     *
     * @param array $dataset
     * @param int $indexDimension
     * @param int $indexOutput
     * @param array $means
     * @return float
     */
    public function method1(array $dataset, int $indexDimension, int $indexOutput, array $means): float
    {
        $this->reset();
        $denominator = 0;
        foreach ($dataset as $row) {
            $this->slope += ($row[0][$indexDimension] - $means[0][$indexDimension]) * ($row[1][$indexOutput] - $means[1][$indexOutput]);
            $denominator += pow(($row[0][$indexDimension] - $means[0][$indexDimension]), 2);
        }

        if ($denominator === 0) {
            $this->slope = 0;
        } else {
            $this->slope /= $denominator;
        }

        return $this->slope;
    }

    /**
     * calculate the slope using the learning rate following the formula :
     *  slope = previousSlope - learningRate * error * input;
     * @param float $input
     * @param float $learningRate
     * @param float $error
     */
    public function calculateSlope(float $input, float $learningRate, float $error)
    {
        $this->slope = $this->slope - $learningRate * $error * $input;
    }

    /**
     * returns the slope
     * @return float
     */
    public function getSlope(): float
    {
        return $this->slope;
    }

    /**
     * resets the slopeCalculator by setting the slope to 0
     */
    public function reset()
    {
        $this->slope = 0;
    }
}