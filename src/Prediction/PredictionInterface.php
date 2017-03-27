<?php

namespace Zeeml\Algorithms\Prediction;

use Zeeml\DataSet\DataSet;

interface PredictionInterface
{
    public function predict(float $output): float;
}