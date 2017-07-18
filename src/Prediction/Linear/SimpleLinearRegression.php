<?php

namespace Zeeml\Algorithms\Prediction\Linear;

use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\Algorithms\Exceptions\CalculusResultNotFound;
use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Formulas\Accuracy;
use Zeeml\Algorithms\Formulas\SimpleLinearIntercept;
use Zeeml\Algorithms\Formulas\SimpleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\DataSet\DataSet;

/**
 * Class SimpleLinearRegression that trains the dataSet following the simple linear regression method
 * Assumes the dataSet is binary (takes the first input and the last one)
 *
 * This class works with a two dimensional array that looks like :
 *   [
 *        input   output
 *      [  [1] ,   [2]   ],
 *      [  [4] ,   [5]   ],
 *      [  [5] ,   [7]   ],
 *      ....
 *   ]
 *
 * Where the index 0 contains the input, the index 1 contains the output
 * @package Zeeml\Algorithms\Adapter
 */
class SimpleLinearRegression extends LinearAlgorithms
{
    /**
     * Trains the dataSet following the Simple Linear Regression Algorithm and calculates the slope and intercept
     * @param DataSet $dataSet
     * @param float $learningRate
     * @return AlgorithmsInterface
     */
    public function fit(DataSet $dataSet, float $learningRate = 0.0): AlgorithmsInterface
    {
        $this
            ->calculator
            ->using($dataSet)
            ->calculate(new Mean())
            ->then(new SimpleLinearSlope())
            ->then(new SimpleLinearIntercept())
        ;

        return $this;
    }

    /**
     * tests the dataSet using the intercept and slope found during the fit and returns the accuracy of the algorithm
     * Takes the dataSet by reference and fills it with prediction
     *
     * @param DataSet $dataSet
     * @return void
     * @throws WrongUsageException
     */
    public function test(DataSet $dataSet)
    {
        try {
            foreach ($dataSet as $instance) {
                $prediction = $this->predict($instance->dimension(0));
                $instance->addResult(self::class, $prediction);
            }
        } catch (MissingResultException $exception) {
            throw new WrongUsageException('Prediction can not be called before performing a fit');
        }
    }

    /**
     * Returns the prediction for a fiven input :
     * @param float $input
     * @return float
     * @throws WrongUsageException
     */
    public function predict(float $input): float
    {
        try {
            return $this
                ->calculator
                ->calculate(new SimpleLinearPrediction($input))
                ->getFormulasResults()
                ->getLast()
            ;
        } catch (MissingResultException $exception) {
            throw new WrongUsageException('Prediction can not be called before performing a fit');
        }
    }

    /**
     * Getter for slope
     * @return float
     * @throws WrongUsageException
     */
    public function getSlope(): float
    {
        try {
            return $this->calculator->getFormulasResults()->get(SimpleLinearSlope::class);
        } catch (CalculusResultNotFound $exception) {
            throw new WrongUsageException('The slope was not yet calculated');
        }
    }

    /**
     * Getter for intercept
     * @return float
     * @throws WrongUsageException
     */
    public function getIntercept(): float
    {
        try {
            return $this->calculator->getFormulasResults()->get(SimpleLinearIntercept::class);
        } catch (CalculusResultNotFound $exception) {
            throw new WrongUsageException('The intercept was not yet calculated');
        }
    }
}
