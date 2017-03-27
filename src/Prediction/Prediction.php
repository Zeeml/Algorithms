<?php

namespace Zeeml\Algorithms\Prediction;

use Zeeml\Algorithms\Algorithms;
use Zeeml\DataSet\DataSet;
use Zeeml\DataSet\DataSetFactory;

abstract class Prediction extends Algorithms implements PredictionInterface
{
    /**
     * In a prediction context, calling process is replaced by predict
     * @param float $data
     * @return float
     */
    final public function process(float $data): float
    {
        return $this->predict($data);
    }
}