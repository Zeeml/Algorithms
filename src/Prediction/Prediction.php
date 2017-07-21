<?php

namespace Zeeml\Algorithms\Prediction;

use Zeeml\Algorithms\Algorithms;
use Zeeml\DataSet\DataSet;

abstract class Prediction extends Algorithms implements PredictionInterface
{
    const PREDICTION = 'prediction';

    /**
     * In a prediction context, calling process is replaced by predict
     * @param DataSet $dataSet
     * @return float
     */
    final public function process(DataSet $dataSet)
    {
        return $this->predict($dataSet);
    }
}