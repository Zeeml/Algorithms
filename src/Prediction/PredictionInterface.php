<?php

namespace Zeeml\Algorithms\Prediction;

/**
 * Interface PredictionInterface
 * @package Zeeml\Algorithms\Prediction
 */
interface PredictionInterface
{
    public function prepare();

    public function train();

    public function predict($input);
}
