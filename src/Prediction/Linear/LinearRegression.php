<?php

namespace Zeeml\Algorithms\Prediction\Linear;

use Kanel\Specification\Specification;
use Zeeml\Algorithms\Algorithms;
use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\Algorithms\DataSet;
use Zeeml\Algorithms\Exceptions\CalculusResultNotFound;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Formulas\LinearIntercept;
use Zeeml\Algorithms\Formulas\SimpleLinearPrediction;
use Zeeml\Algorithms\Formulas\SimpleLinearSlope;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\Transpose;
use Zeeml\Algorithms\Specifications\HasOneInput;

/**
 * Class LinearRegression that trains the dataSet following the linear regression method
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
class LinearRegression extends LinearAlgorithms
{
    protected $algorithm;
    /**
     * Trains the dataSet following the Simple Linear Regression Algorithm and calculates the slope and intercept
     * @param array $dataSet
     * @param float $learningRate
     * @return AlgorithmsInterface
     * @throws WrongUsageException
     */
    public function fit(array &$dataSet, float $learningRate = 0.0): AlgorithmsInterface
    {
        if (count($dataSet[DataSet::OUTPUTS_INDEX]) > 1 ) {
            throw new WrongUsageException('A linear regression can not be applied with multiple outputs');
        }

        if (count($dataSet[DataSet::INPUTS_INDEX]) == 1) {
            (new SimpleLinearRegression())->fit($dataSet, $learningRate);
        } else {
            (new MultipleLinearRegression())->fit($dataSet, $learningRate);
        }

        return $this;
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
