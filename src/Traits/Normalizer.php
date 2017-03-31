<?php

namespace Zeeml\Algorithms\Traits;

use Zeeml\Dataset\DatasetInterface;

/**
 * trait ErrorCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait Normalizer
{
    /**
     *  Normalization, scales all numeric variables in the range [0,1] following the formula:
     *         X - Xmin
     *  X =  -------------
     *        Xman - Xmin
     *
     * @param DatasetInterface $dataset
     */
    public function normalize(DatasetInterface $dataset, array $minInputs, array $maxInputs)
    {
        //@TODO implement the core of the function
    }

}