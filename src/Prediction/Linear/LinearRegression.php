<?php

namespace Zeeml\Algorithms\Prediction\Linear;

use Zeeml\Algorithms\AlgorithmsInterface;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\Algorithms\Formulas\Mean;
use Zeeml\Algorithms\Formulas\MultipleLinearCoefficients;
use Zeeml\Algorithms\Formulas\SimpleLinearCoefficients;
use Zeeml\Algorithms\Prediction\Prediction;
use Zeeml\DataSet\DataSet;
use Zeeml\Algorithms\Formulas\Benchmark;
use Zeeml\Algorithms\Formulas\LinearPrediction;

/**
 * Class LinearRegression that trains the dataSet following either the simple or multiple linear regression
 *  - Simple Linear Regression : if the number of dimension is 1
 *  - Multiple Linear Regression : if the number of dimension is greater than 1
 *
 * The number of outputs must always be equal to 1 (an exception is thrown otherwise)
 */
class LinearRegression extends Prediction
{
    protected $coefficients = [];

    /**
     * Trains the dataSet following the Linear Regression Algorithm
     * @param DataSet $dataSet
     * @param float $learningRate
     * @return AlgorithmsInterface
     * @throws WrongUsageException
     */
    public function fit(DataSet $dataSet, float $learningRate = 0.0): AlgorithmsInterface
    {
        $outputSize = count($dataSet->getMapper()->getOutputKeys());
        if ($outputSize !== 1) {
            throw new WrongUsageException('Linear regression assumes only one output, ' . $outputSize . ' given');
        }

        if (count($dataSet->getMapper()->getDimensionKeys()) === 1) {
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

    /**
     * tests the dataSet using the intercept and slope found during the fit and returns the accuracy of the algorithm
     * Takes the dataSet by reference and fills it with prediction
     *
     * @param DataSet $dataSet
     * @throws WrongUsageException
     */
    public function test(DataSet $dataSet)
    {
        if (empty($this->coefficients)) {
            throw new WrongUsageException('Test can not be run after fit');
        }

        $this->predict($dataSet);
    }

    /**
     * Makes a linear prediction of input based on coefficients
     * @param DataSet $dataSet
     * @throws WrongUsageException
     */
    public function predict(DataSet $dataSet)
    {
        foreach ($dataSet as $instance) {
            $prediction = $this
                ->calculator
                ->calculate(new LinearPrediction($instance->getDimensions(), $this->coefficients))
                ->getResult()
                ->last()
            ;
            $instance->addResult(
                static::class,
                [
                    'type'   => self::PREDICTION,
                    'result' => $prediction
                ]
            );
        }

        $this->calculator->using($dataSet)->calculate(new Benchmark(LinearRegression::class));
        $results = $this->calculator->getResult()->of(Benchmark::class);

        $this->accuracy = $results[Benchmark::ACCURACY] ?? 0;
        $this->rmse = $results[Benchmark::RMSE] ?? 0;
    }

    /**
     * Gets the coefficients
     * @return array
     */
    public function getCoefficients(): array
    {
        return $this->coefficients;
    }
}
