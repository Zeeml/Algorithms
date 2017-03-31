<?php

namespace Zeeml\Algorithms\Traits;

use Zeeml\Dataset\DatasetInterface;

/**
 * trait ErrorCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait MinMaxCalculator
{
    protected $minInputs;
    protected $maxInputs;
    protected $minOutputs;
    protected $maxOutputs;

    /**
     * @param DatasetInterface $dataset
     */
    public function calculateMinMax(DatasetInterface $dataset)
    {
        foreach ($dataset as $instance) {
            foreach ($instance->inputs() as $index => $input) {
                if (!isset($this->minInputs[$index])) {
                    $this->minInputs[$index] = $input;
                    $this->maxInputs[$index] = $input;
                } else {
                    $this->minInputs[$index] = min($this->minInputs[$index], $input);
                    $this->maxInputs[$index] = max($this->maxInputs[$index], $input);
                }
            }
            foreach ($instance->outputs() as $index => $output) {
                if (!isset($this->minOutputs[$index])) {
                    $this->minOutputs[$index] = $output;
                    $this->maxOutputs[$index] = $output;
                } else {
                    $this->minOutputs[$index] = min($this->minOutputs[$index], $output);
                    $this->maxOutputs[$index] = max($this->maxOutputs[$index], $output);
                }
            }
        }
    }

    /**
     * returns the min value of the inputs
     * @return array
     */
    public function getMinInputs(): array
    {
        return $this->minInputs;
    }

    /**
     * returns the max value of the inputs
     * @return array
     */
    public function getMaxInputs(): array
    {
        return $this->maxInputs;
    }

    /**
     * returns the min value of the outputs
     * @return array
     */
    public function getMinOutputs(): array
    {
        return $this->minOutputs;
    }

    /**
     * returns the max value of the outputs
     * @return array
     */
    public function getMaxOutputs(): array
    {
        return $this->maxOutputs;
    }

    public function reset()
    {
        $this->minInputs = [];
        $this->maxInputs = [];
        $this->minOutputs = [];
        $this->maxOutputs = [];
    }
}