<?php

namespace Zeeml\Algorithms\Prediction\Logistic;

use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Prediction\Prediction;
use Zeeml\DataSet\DataSet;

class LogisticRegression extends Prediction
{

    public function fit(DataSet $dataSet, float $learningRate = 0.0): AlgorithmsInterface
    {
        $outputSize = count($dataSet->mapper()->outputKeys());
        if ($outputSize !== 1) {
            throw new WrongUsageException('Logistic regression assumes only one output, ' . $outputSize . ' given');
        }

        if (count($dataSet->mapper()->dimensionKeys()) === 1) {
            $this
                ->calculator
                ->using($dataSet)
                ->calculate(new Mean())
                ->then(new SimpleLinearCoefficients());
            ;
        } else {
            $this->coefficients = $this
                ->calculator
                ->using($dataSet)
                ->calculate(new MultipleLinearCoefficients())
                ->getResult()
                ->last()
            ;
        }

        $this->coefficients = $this->calculator->getResult()->last();

        return $this;
    }

    public function test(DataSet $data)
    {
        // TODO: Implement test() method.
    }

    public function predict($output)
    {
        // TODO: Implement predict() method.
    }
}