<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Exceptions\WrongUsageException;

class LinearPrediction extends Formulas
{
    protected $inputs;
    protected $coefficients;

    public function __construct(array $inputs, array $coefficients)
    {
        $this->inputs = $inputs;
        $this->coefficients = $coefficients;
    }

    /**
     * the linear prediction is calculated for each input of the dataSet at a specific index using a slope and an intercept :
     *
     *    prediction = B0 + B1 * X1 + B2 * X2 ....
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

        $trainingInputsCounts = count($this->coefficients) - 1;
        if ($trainingInputsCounts != count($this->inputs)) {
            throw new WrongUsageException('Linear regression was calculated for ' . $trainingInputsCounts . ' inputs');
        }

        array_unshift($this->inputs, 1);

        foreach ($this->coefficients as $index => $coefficient) {
            $this->result = $this->result ?? 0;
            $this->result += $coefficient * $this->inputs[$index];
        }

        return $this;
    }
}