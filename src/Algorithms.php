<?php

namespace Zeeml\Algorithms;

/**
 * abstract Class AbstractAlgorithms
 * @package Zeeml\Algorithms\Algorithms
 */
abstract class Algorithms implements AlgorithmsInterface
{
    protected $calculator;
    protected $accuracy;
    protected $rmse;

    /**
     * Algorithms constructor.
     * @param Calculator|null $calculator
     */
    final public function __construct()
    {
        $this->calculator = new Calculator();
        $this->accuracy = $this->rmse = 0;
    }

    /**
     * @return Calculator
     */
    public function getCalculator()
    {
        return $this->calculator;
    }

    /**
     * returns the accuracy
     * @return float
     */
    public function getAccuracy(): float
    {
        return $this->accuracy;
    }

    /**
     * returns the Root Mean Squared Error
     * @return float
     */
    public function getRmse(): float
    {
        return $this->rmse;
    }
}
