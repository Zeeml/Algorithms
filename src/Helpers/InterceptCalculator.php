<?php

namespace Zeeml\Algorithms\Helpers;

trait InterceptCalculator
{
    protected $intercept = 0;

    /**
     * Calculating the intercept following the formula:
     *   intercept = mean(y) - slope * mean(x)
     * @param float $slope
     * @param float $meanInput
     * @param float $meanOutput
     * @return bool
     */
    public function calculateIntercept(float $slope, float $meanInput, float $meanOutput): bool
    {
        $this->intercept = $meanOutput - ($slope * $meanInput);

        return true;
    }

    /**
     * returns the intercept
     * @return float
     */
    public function getIntercept(): float
    {
        return $this->intercept;
    }
}