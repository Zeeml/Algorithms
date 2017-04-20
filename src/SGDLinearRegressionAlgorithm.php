<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Traits\InterceptCalculator;
use Zeeml\Algorithms\Traits\InterceptsHistory;
use Zeeml\Algorithms\Traits\PredictionCalculator;
use Zeeml\Algorithms\Traits\LinearRegressionScore;
use Zeeml\Algorithms\Traits\MeanCalculator;
use Zeeml\Algorithms\Traits\PredictionErrorCalculator;
use Zeeml\Algorithms\Traits\PredictionErrorsHistory;
use Zeeml\Algorithms\Traits\RmseCalculator;
use Zeeml\Algorithms\Traits\ScoreCalculator;
use Zeeml\Algorithms\Traits\SlopeCalculator;
use Zeeml\Algorithms\Traits\SlopesHistory;

/**
 * Class SGDLinearRegressionAlgorithm
 * class that trains a set of data following the linear regression method using stochastic gradient descent
 */
class SGDLinearRegressionAlgorithm extends AbstractAlgorithms
{
    use InterceptCalculator, SlopeCalculator, PredictionCalculator {
        InterceptCalculator::calculateIntercept2 as calculateIntercept;
        SlopeCalculator::calculateSlope1 as calculateSlope;
        PredictionCalculator::linearPrediction as predict;
    }
    use MeanCalculator;
    use PredictionErrorCalculator;
    use RmseCalculator;
    use ScoreCalculator;
    use InterceptsHistory;
    use SlopesHistory;
    use PredictionErrorsHistory;

    /**
     * StochasticGradientDescentAlgorithm constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @param array $dataset
     * @param float $learningRate
     * @param float $interceptStart
     * @param float $slopeStart
     * @return AlgorithmsInterface
     */
    public function fit(array $dataset, float $learningRate = 0.0, float $interceptStart = 0, float $slopeStart = 0): AlgorithmsInterface
    {
        $this->interceptsHistory[] = $this->intercept = $interceptStart;
        $this->slopesHistory[] = $this->slopes[0] = $slopeStart;
        $this->predictionErrorsHistory[] = null;

        foreach ($dataset as $row) {
            //Getting the input
            //Predicting the result based on the intercept/slope from formula : prediction = intercept + slope * input
            $this->predict($row[0][0], $this->getIntercept(), $this->getSlope(0));
            //calculating the error from formula : error = prediction - output
            $this->calculateError($this->getPrediction(), $row[1][0]);
            //Calculating the new intercept based on the old one from formula :  intercept = intercept - learningRate * error
            $this->calculateIntercept($this->getIntercept(), $learningRate, $this->getPredictionError());
            //Calculating the new slope based on the old one from formula : slope = slope - learningRate * error * input;
            $this->calculateSlope($row[0][0], $learningRate, $this->getPredictionError());

            //archive the slope/intercept/error
            $this->interceptsHistory[] = $this->getIntercept();
            $this->slopesHistory[] = $this->getSlope(0);
            $this->predictionErrorsHistory[] = $this->getPredictionError();
        }

        return $this;
    }

    /**
     * @param DatasetInterface $dataset
     * @return float
     */
    public function test(array $dataset)
    {
        $means = $this->calculateMeans($dataset);
        $this->calculateRmse($dataset);
        $this->calculatescore($dataset, $means[1][0]);
    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function process(float $input): float
    {
        return $this->predict($input, $this->getIntercept(), $this->getSlope(0));
    }

    public function reset()
    {
        $this->resetInterceptsHistory();
        $this->errorsHistory = [];
        $this->resetRmse();
        $this->resetSlopes();
        $this->resetIntercept();
        $this->resetPrediction();
        $this->resetPredictionError();
        $this->resetScore();
    }

    public function getErrorsHistory()
    {
        return $this->errorsHistory;
    }
}
