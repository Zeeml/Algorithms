<?php

namespace Zeeml\Algorithms\Algorithms\Factory;

use Zeeml\Algorithms\Algorithms\LogisticRegressionAlgorithm;
use Zeeml\Algorithms\Algorithms\SimpleLinearRegressionAlgorithm;
use Zeeml\Algorithms\Algorithms\SGDLinearRegressionAlgorithm;

/**
 * Class AlgorithmsFactory that instantiates algorithms
 * @package Zeeml\Algorithms\Algorithms\Factory
 */
class AlgorithmsFactory
{
    /**
     * Function that instantiates the Simple Linear Regression Algorithm
     * @return SimpleLinearRegressionAlgorithm
     */
    public static function simpleLinearRegressionAlgorithm(): SimpleLinearRegressionAlgorithm
    {
        return new SimpleLinearRegressionAlgorithm();
    }

    /**
     * Function that instantiates the Stochastic Gradient Descent Algorithm
     * @return StochasticGradientDescentAlgorithm
     */
    public static function SGDLinearRegressionAlgorithm(): SGDLinearRegressionAlgorithm
    {
        return new SGDLinearRegressionAlgorithm();
    }

    /**
     * Function that instantiates the Logistic Regression Algorithm
     * @return LogisticRegressionAlgorithm
     */
    public static function LogisticRegressionAlgorithm(): LogisticRegressionAlgorithm
    {
        return new LogisticRegressionAlgorithm();
    }
}