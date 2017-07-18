<?php

namespace Zeeml\Algorithms\Prediction\Linear;

use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\AlgorithmsOld\Traits\History;

class StochasticGradientDescent extends LinearAlgorithms
{
    use History;

    public function fit(array $dataSet, float $learningRate = 0.0, int $epochs = 1): AlgorithmsInterface
    {
        $this->setIntercept(mt_rand() / mt_getrandmax());
        $this->setSlope(mt_rand() / mt_getrandmax());

        for ($i = 1; $i <= $epochs; $i++) {
            foreach ($dataSet as &$row) {
                $prediction = $this->predict($row[0][0]);
                $error = $prediction - $row[1][0];

                $this->intercept = $this->calculateIntercept($this->getIntercept(), $learningRate, $error);
                $this->calculateSlope($row[0][0], $learningRate, $error);

                //archive the slope/intercept/error
                $this->addHistory('intercept', $this->getIntercept());
                $this->addHistory('slopes', $this->getSlopes());
                $this->addHistory('error', $this->getPredictionError());
            }
        }

        return $this;
    }

    public function test(array &$data): float
    {
        // TODO: Implement test() method.
    }

    protected function calculateError()
    {

    }

}