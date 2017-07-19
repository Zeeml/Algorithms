<?php

namespace Zeeml\Algorithms\Prediction\Linear;

use Kanel\Specification\Specification;
use Zeeml\Algorithms\Algorithms;
use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\Algorithms\Exceptions\CalculusResultNotFound;
use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Formulas\LinearIntercept;
use Zeeml\Algorithms\Formulas\MultipleLinearCoefficients;
use Zeeml\Algorithms\Formulas\MultipleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\Transpose;
use Zeeml\Algorithms\Prediction\PredictionInterface;
use Zeeml\Algorithms\Specifications\HasOneInput;
use Zeeml\DataSet\DataSet;

/**
 * Class MultipleLinearRegression that trains the dataSet following the multiple linear regression method
 * Assumes the dataSet is not binary (more than input and 1 output)
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
class MultipleLinearRegression extends LinearAlgorithms
{
    protected $coefficients;

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
            ->calculate(new MultipleLinearCoefficients())
        ;

        return $this;
    }

    /**
     * tests the dataSet using the intercept and slope found during the fit and returns the accuracy of the algorithm
     * Takes the dataSet by reference and fills it with prediction
     *
     * @param DataSet $dataSet
     * @return float the RMSE (Root Mean Squared Error)
     * @throws WrongUsageException
     */
    public function test(DataSet $dataSet)
    {
        try {
            foreach ($dataSet as $instance) {
                $prediction = $this->predict($instance->dimensions());
                $instance->addResult(self::class, $prediction);
            }
        } catch (MissingResultException $exception) {
            throw new WrongUsageException('Prediction can not be called before performing a fit');
        }
    }

    /**
     * @param float $input
     * @return float
     * @throws WrongUsageException
     */
    public function predict($input)
    {
        try {
            return $this
                ->calculator
                ->calculate(new MultipleLinearPrediction($input))
                ->getResult()
                ->last()
                ;
        } catch (MissingResultException $exception) {
            throw new WrongUsageException('Prediction can not be called before performing a fit');
        }
    }

    /**
     * Getter for the coefficients calculated
     * @return array
     * @throws WrongUsageException
     */
    public function getCoefficients(): array
    {
        try {
            return $this->calculator->getResult()->of(MultipleLinearCoefficients::class);
        } catch (CalculusResultNotFound $exception) {
            throw new WrongUsageException('The coefficients were not calculated');
        }
    }

}
