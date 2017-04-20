<?php

namespace Zeeml\Algorithms\Traits;

use Zeeml\Algorithms\Exceptions\MissingMethodException;

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
     * @param array $dataset
     * @return float
     * @throws MissingMethodException
     */
    public function calculateRmse(array $dataset)
    {
        if (! method_exists($this, 'process')) {
            throw new MissingMethodException('Child class must implement process method');
        }

        $rmse = 0;
        foreach ($dataset as $row) {
            $prediction = $this->process($row[0][0]);
            $rmse +=  pow($prediction - floatval($row[1][0]), 2);
        }

        $this->rmse = sqrt($rmse / count($dataset));
    }

    /**
     * returns the rmse
     * @return floar
     */
    public function getRmse(): float
    {
        return $this->rmse;
    }

    public function resetRmse()
    {
        $this->rmse = 0;
    }

}
