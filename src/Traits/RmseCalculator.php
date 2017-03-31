<?php

namespace Zeeml\Algorithms\Traits;

use Zeeml\Algorithms\Exceptions\MissingMethodException;
use Zeeml\Dataset\DatasetInterface;

/**
 * trait RmseCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait RmseCalculator
{
    protected $rmse;

    /**
     * calculates the RMSE following the formula:
     *
     *               Σ (prediction - output)²
     * RMSE =     √  ------------------------
     *                         n
     *
     * where n is the number of elements in the dataset
     *
     * @param DatasetInterface $dataset
     * @return float
     * @throws MissingMethodException
     */
    public function calculateRmse(DatasetInterface $dataset)
    {
        if (! method_exists($this, 'process')) {
            throw new MissingMethodException('Child class must implement process method');
        }

        $rmse = 0;
        foreach ($dataset as $instance) {
            $prediction = $this->process($instance->inputs()[0]);
            $rmse +=  pow($prediction - floatval($instance->outputs()[0]), 2);
        }

        $this->rmse = sqrt($rmse / count($dataset->instances()));
    }

    /**
     * returns the rmse
     * @return floar
     */
    public function getRmse(): float
    {
        return $this->rmse;
    }

    public function reset()
    {
        $this->rmse = 0;
    }

}
