<?php

namespace Zeeml\Algorithms\Traits;

use Zeeml\Algorithms\Exceptions\EmptyDatasetException;
use Zeeml\Algorithms\Exceptions\IndexNotFoundException;
use Zeeml\Dataset\Dataset;
use Zeeml\Dataset\DatasetInterface;

/**
 * trait ErrorCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait PredictionErrorCalculator
{
    protected $error;

    /**
     * calculates the error following the formula :
     * error = prediction - output
     * @param float $prediction
     * @param float $output
     * @return float
     */
    public function calculateError(float $prediction, float $output): float
    {
        $this->error = $prediction - $output;

        return $this->error;
    }

    /**
     * returns the error
     * @return array
     */
    public function getPredictionError(): float
    {
        return $this->error;
    }

    public function resetPredictionError()
    {
        $this->error = 0;
    }
}