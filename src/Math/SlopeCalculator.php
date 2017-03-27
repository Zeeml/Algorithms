<?php

namespace Zeeml\Algorithms\Math;

use Zeeml\Dataset\Dataset;
use Zeeml\Dataset\DatasetInterface;

trait SlopeCalculator
{
    protected $slope;

    /**
     * Calculating the slope of each input following the formula:
     *               Σ(x - mean(x))(y - mean(y))
     *   slope =     ---------------------------
     *                     Σ(x - mean(x))²
     * The slope can only be calculated for one output.
     * @param Dataset $dataset
     * @param int $inputIndex
     * @param int $outputIndex
     * @param float $meanInput
     * @param float $meanOuput
     * @return bool
     */
    public function calculateSlope(DatasetInterface $dataset, int $inputIndex, int $outputIndex, float $meanInput, float $meanOuput): bool
    {
        $this->slope = 0;
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

        return true;
    }

    /**
     * returns the slope
     * @return float
     */
    public function getSlope(): float
    {
        return $this->slope;
    }
}