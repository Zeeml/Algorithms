<?php

namespace Zeeml\Algorithms\Prediction;

/**
 * Class LinearRegression
 * class that trains a set of data following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
class SimpleLinearRegressionStochasticGradientDescend extends AbstracPrediction
{
    protected $epochs = 1;
    protected $learningRate = 0.1;
    protected $intercepts;
    protected $slopes;
    protected $errors;

    public function prepare(): PredictionInterface
    {
        $this->dataset->prepare(1, 1);

        return $this;
    }

    /**
     * functions that trains the data sent,
     * @return bool
     */
    public function train(): PredictionInterface
    {
        $this->intercepts = [0];
        $this->slopes = [0];
        $this->errors = [];
        for ($epoch = 1; $epoch <= $this->epochs; $epoch++) {
            foreach ($this->dataset as $instance) {
                $intercept = end($this->intercepts);
                $slope = end($this->slopes);
                $input = $instance->inputs()[0];

                $prediction = $intercept + $slope * $input;
                $error = $prediction - $instance->outputs()[0];

                $this->errors[] = $error;
                $this->intercepts[] = $intercept - $this->learningRate * $error;
                $this->slopes[] = $slope - $this->learningRate * $error * $input;
            }
        }

        return $this;
    }

    public function updateDataset()
    {
        foreach ($this->dataset as $instance) {
            $instance->result(
                [
                    'LinearRegressionStochasticGradientDescent' => [
                        'intercepts'   => $this->intercepts(),
                        'slopes'       => $this->slopes,
                        'erros'        => $this->errors,
                        'learningRate' => $this->learningRate,
                        'epochs'       => $this->epochs,
                    ]
                ]
            );
        }
    }

    /**
     * function that returns the prediction after the training using thr formula :
     * prediction = intercept + slope * input
     * @param $input
     * @return float
     */
    public function predict($input): float
    {
        return end($this->intercepts) + end($this->errors) * $input;
    }

    /**
     * @return float
     */
    public function getLearningRate(): float
    {
        return $this->learningRate;
    }

    /**
     * @param float $learningRate
     * @return PredictionInterface
     */
    public function setLearningRate(float $learningRate): PredictionInterface
    {
        $this->learningRate = $learningRate;

        return $this;
    }

    /**
     * @return int
     */
    public function getEpochs(): int
    {
        return $this->epochs;
    }

    /**
     * @param int $epochs
     * @return PredictionInterface
     */
    public function setEpochs(int $epochs): PredictionInterface
    {
        $this->epochs = $epochs;

        return $this;
    }

    /**
     * @return array
     */
    public function getErros(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getIntercepts(): array
    {
        return $this->intercepts;
    }

    /**
     * @return array
     */
    public function getSlopes(): array
    {
        return $this->slopes;
    }
}
