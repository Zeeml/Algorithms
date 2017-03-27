<?php

namespace Zeeml\Algorithms\Prediction;

use Zeeml\Algorithms\Helpers\InterceptCalculator;
use Zeeml\Algorithms\Helpers\MeanCalculator;
use Zeeml\Algorithms\Helpers\SlopeCalculator;

/**
 * Class LinearRegression
 * class that trains a set of data following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
class LogisticRegression extends AbstractClassification
{
    public function prepare(): PredictionInterface
    {
        $this->dataset->prepare(2, 1);

        return $this;
    }

    /**
     * functions that trains the data sent,
     * @return bool
     */
    public function train(): ClassificationInterface
    {

        return $this;
    }

    public function updateDataset()
    {
        foreach ($this->dataset as $instance) {
            $instance->result(
                [
                    'LogisticRegression' => [
                    ]
                ]
            );
        }
    }

    /**
     * function that returns thepredicted class after the training using thr formula :
     * @param $input
     */
    public function classify($input)
    {

    }
}
