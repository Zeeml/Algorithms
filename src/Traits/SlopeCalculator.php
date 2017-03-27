<?php

namespace Zeeml\Algorithms\Algorithms\Traits;

use Zeeml\Dataset\Dataset;
use Zeeml\Dataset\DatasetInterface;

/**
 * trait SlopeCalculator
 * @package Zeeml\Algorithms\Algorithms\Traits
 */
trait SlopeCalculator
{
    protected $slope;

    /**
     * Calculating the slope of each input of the dataset following the formula:
     *               Σ(x - mean(x))(y - mean(y))
     *   slope =     ---------------------------
     *                     Σ(x - mean(x))²
     * The slope can only be calculated for one output.
     * @param Dataset $dataset the dataset to calculate the slope for
     * @param int $inputIndex for which dimension the slope will be calculated
     * @param int $outputIndex for which output the slope will be calculated
     * @param float $meanInput the mean of the inputs
     * @param float $meanOuput the mean of the outputs
     * @return bool
     */
    public function calculateSlopeDataset(DatasetInterface $dataset, int $inputIndex, int $outputIndex, float $meanInput, float $meanOuput)
    {
        $denominator = 0;

        foreach ($dataset as $instance) {
            $xMinusMeanX = ($instance->inputs()[$inputIndex] - $meanInput);
            $yMinusMeanY = ($instance->outputs()[$outputIndex] - $meanOuput);
            $this->slope  += $xMinusMeanX * $yMinusMeanY;
            $denominator += pow($xMinusMeanX, 2);
        }
        if ($denominator !== 0) {
            $this->slope =  $this->slope / $denominator;
        }
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