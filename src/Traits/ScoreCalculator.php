<?php

namespace Zeeml\Algorithms\Traits;

use Zeeml\Algorithms\Exceptions\MissingMethodException;
use Zeeml\Dataset\DatasetInterface;

/**
 * trait RmseCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait ScoreCalculator
{
    protected $score;

    /**
     * The score function returns the coefficient of determination R^2 of the prediction.
     * The coefficient R^2 is defined as (1 - u/v), where u is the regression sum of squares ((y_true - y_pred) ** 2).sum()
     * and v is the residual sum of squares ((y_true - y_true.mean()) ** 2).sum().
     * Best possible score is 1.0 and it can be negative (because the model can be arbitrarily worse).
     * A constant model that always predicts the expected value of y, disregarding the input features, would get a R^2 score of 0.0.
     * @param array $dataset
     * @param float $meanOutput
     * @throws MissingMethodException
     */
    public function calculateScore(array $dataset, float $meanOutput)
    {
        if (! method_exists($this, 'process')) {
            throw new MissingMethodException('Child class must implement process method');
        }

        $score = 0;
        $denominator = 0;
        foreach ($dataset as $row) {
            $prediction = $this->process($row[0][0]);
            $score +=  pow(floatval($row[1][0]) - $prediction, 2);
            $denominator += pow(floatval($row[1][0]) - $meanOutput, 2);
        }

        $this->score = 1 - ($score / $denominator);
    }

    /**
     * returns the rmse
     * @return floar
     */
    public function getScore(): float
    {
        return $this->score;
    }

    public function resetScore()
    {
        $this->score = 0;
    }

}
