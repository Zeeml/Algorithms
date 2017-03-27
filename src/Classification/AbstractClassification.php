<?php

namespace Zeeml\Algorithms\Prediction;

use Zeeml\Dataset\PredictionDataset;

/**
 * Class PredictionAbstract
 * @package Zeeml\Algorithms\Prediction
 */
abstract class AbstractClassification implements ClassificationInterface
{
    protected $dataset;

    /**
     * Prediction Algorithms constructor.
     * AbstracPrediction constructor.
     * @param PredictionDataset $dataset
     */
    public function __construct(PredictionDataset $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * getter for dataset
     * @return PredictionDataset
     */
    public function getDataset(): PredictionDataset
    {
        return $this->dataset;
    }
}
