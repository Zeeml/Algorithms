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
        $outputSize = count($dataSet->getMapper()->getOutputKeys());
        if ($outputSize !== 1) {
            throw new WrongUsageException('Logistic regression assumes only one output, ' . $outputSize . ' given');
        }

        return $this;
    }

    public function test(DataSet $data)
    {
        // TODO: Implement test() method.
    }

    public function predict(DataSet $dataSet)
    {
        // TODO: Implement predict() method.
    }
}