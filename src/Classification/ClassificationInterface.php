<?php

namespace Zeeml\Algorithms\Prediction;

/**
 * Interface PredictionInterface
 * @package Zeeml\Algorithms\Prediction
 */
interface ClassificationInterface
{
    public function prepare();

    public function train();

    public function classify($input);

    public function updateDataset();
}
