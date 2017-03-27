<?php

namespace Zeeml\Algorithms\Prediction\Linear;

use Kanel\Specification\Specification;
use Zeeml\Algorithms\Algorithms;
use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\Algorithms\Exceptions\CalculusResultNotFound;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Formulas\LinearIntercept;
use Zeeml\Algorithms\Formulas\SimpleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\Transpose;
use Zeeml\Algorithms\Specifications\HasOneInput;

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
    /**
     * Trains the dataSet following the Simple Linear Regression Algorithm and calculates the slope and intercept
     * @param array $dataSet
     * @param float $learningRate
     * @return AlgorithmsInterface
     */
    public function fit(array &$dataSet, float $learningRate = 0.0): AlgorithmsInterface
    {
       $transpose = (new Transpose($dataSet))->calculate();
    }

    /**
     * tests the dataSet using the intercept and slope found during the fit and returns the accuracy of the algorithm
     * Takes the dataSet by reference and fills it with prediction
     *
     * @param array $dataSet
     * @return float the RMSE (Root Mean Squared Error)
     * @throws WrongUsageException
     */
    public function test(array &$dataSet): float
    {
        try {
            $this->calculate(new SimpleLinearPrediction())
            ;
        } catch (CalculusResultNotFound $exception) {
            throw new WrongUsageException('Test can not be run before fit');
        }
    }
}
