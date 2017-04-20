<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait SlopeCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait SlopeCalculator
{
    protected $slopes;

    /**
     * calculate the slope using the learning rate following the formula :
     *
     *  slope = previousSlope - learningRate * error * input;
     *
     * @param float $input
     * @param float $learningRate
     * @param float $error
     */
    public function calculateSlope1(float $input, float $learningRate, float $error, int $index = 0)
    {
        $this->slopes[$index] = $this->slopes[$index]?? 0;
        $this->slopes[$index] = $this->slopes[$index] - $learningRate * $error * $input;
    }

    /**
     * * Calculating the slope of the dataset following the formula:
     *
     *               Σ(x - mean(x))(y - mean(y))
     *   slope =     ---------------------------
     *                     Σ(x - mean(x))²
     *
     * @param array $dataset
     * @param float $meanInputs
     * @param float $meanOutputs
     * @return float
     */
    public function calculateSlope2(array $dataset, float $meanInput, float $meanOutput, int $index = 0): float
    {
        $this->slopes[$index] = $this->slopes[$index]?? 0;
        $denominator = 0;
        foreach ($dataset as $row) {
            $this->slopes[$index] += ($row[0][$index] - $meanInput) * ($row[1][0] - $meanOutput);
            $denominator += pow(($row[0][0] - $meanInput), 2);
        }

        if ($denominator == 0) {
            $this->slopes[$index] = 0;
        } else {
            $this->slopes[$index] /= $denominator;
        }

        return $this->slopes[$index];
    }

    /**
     * returns the slopes of all the indexes
     * @return float
     */
    public function getSlopes(): array
    {
        return $this->slopes;
    }

    /**
     * returns the slope of the specified index
     * @return float
     */
    public function getSlope(int $index): float
    {
        return $this->slopes[$index]?? 0;
    }

    /**
     * resets the slopeCalculator by setting the slope to 0
     */
    public function resetSlopes()
    {
        $this->slopes = [];
    }

    /**
     * resets the slopeCalculator by setting the slope to 0
     */
    public function resetSlope(int $index)
    {
        $this->slopes[$index] = 0;
    }
}