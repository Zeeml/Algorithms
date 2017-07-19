<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Exceptions\WrongUsageException;

class MultipleLinearPrediction extends Formulas
{
    protected $inputs;

    public function __construct(array $inputs)
    {
        $this->inputs = array_values($inputs);
    }

    /**
     * the linear prediction is calculated for each input of the dataSet at a specific index using a slope and an intercept :
     *
     *    prediction = intercept + slope * input
     *
     * @return FormulasInterface
     * @throws MissingResultException
     * @throws WrongUsageException
     */
    public function calculate(): FormulasInterface
    {
        $countInputs = count($this->inputs);

        if (count(array_filter($this->inputs, 'is_numeric')) !== $countInputs) {
            throw new WrongUsageException('Inputs provided are not usable');

        }

        try {
            $coefficients = $this->previousResults->of(MultipleLinearCoefficients::class);
        }  catch (\Throwable $exception) {
            throw new MissingResultException('Can not calculate the linear prediction without knowing the coefficients');
        }

        $trainingInputsCounts = count($coefficients) - 1;
        if ($trainingInputsCounts != count($this->inputs)) {
            throw new WrongUsageException('Linear regression was calculated for ' . $trainingInputsCounts . ' inputs');
        }

        array_unshift($this->inputs, 1);

        foreach ($coefficients as $index => $coefficient) {
            $this->result = $this->result ?? 0;
            $this->result += $coefficient * $this->inputs[$index];
        }

        return $this;
    }
}