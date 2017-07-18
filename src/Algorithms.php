<?php

namespace Zeeml\Algorithms;

/**
 * abstract Class AbstractAlgorithms
 * @package Zeeml\Algorithms\Algorithms
 */
abstract class Algorithms implements AlgorithmsInterface
{
    protected $calculator;

    /**
     * Algorithms constructor.
     * @param Calculator|null $calculator
     */
    final public function __construct(Calculator $calculator = null)
    {
        $this->calculator = $calculator ?? new Calculator();
    }

    /**
     * @return Calculator
     */
    public function getCalculator()
    {
        return $this->calculator;
    }
}
