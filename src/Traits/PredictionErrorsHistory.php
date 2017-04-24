<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait PredictionErrorsHistory
 * @package Zeeml\Algorithms\Traits
 */
trait PredictionErrorsHistory
{
    protected $predictionErrorsHistory = [];

    /**
     * @return array
     */
    public function getPredictionErrorsHistory(): array
    {
        return $this->predictionErrorsHistory;
    }

    /**
     * resets the interceptCalculator by setting the intercept to 0
     */
    public function resetPredictionErrorsHistory()
    {
        $this->predictionErrorsHistory = [];
    }
}