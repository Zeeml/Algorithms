<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\DataSet\DataSet;

class SimpleLinearCoefficients extends Formulas
{
    /**
     * Calculating the slope of the dataSet following the formula:
     *
     *               Σ(x - mean(x)) * (y - mean(y))
     *   slope =     ---------------------------
     *                     Σ(x - mean(x))²
     *
     * and the intercept following the formula:
     *
     *  intercept = mean(y) - slope * mean(x)
     *
     * the result returned is an array(intercept, slope)
     *
     * @return FormulasInterface
     * @throws MissingResultException
     * @throws WrongUsageException
     */
    public function calculate(): FormulasInterface
    {
        if (! $this->dataSet instanceof DataSet) {
            throw new WrongUsageException('DataSet was not provided for slope calculus');
        }

        try {
            $means = $this->previousResults->of(Mean::class);
        } catch (\Throwable $exception) {
            throw new MissingResultException('Can not calculate the linear slope without knowing the mean');
        }

        $slope = 0;
        $denominator = 0;

        foreach ($this->dataSet as $instance) {
            $slope += ($instance->dimension(0) - $means[0][0]) * ($instance->output(0) - $means[1][0]);
            $denominator += pow(($instance->dimension(0) - $means[0][0]), 2);
        }

        if ($denominator === 0) {
            $slope = 0;
        } else {
            $slope /= $denominator;
        }

        $intercept = $means[1][0] - ($slope * $means[0][0]);

        $this->result = [$intercept, $slope];

        return $this;
    }
}