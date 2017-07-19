<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\DataSet;
use Zeeml\Algorithms\Exceptions\MissingResultException;

class SimpleLinearIntercept extends Formulas
{
    /**
     * Calculating the slope of the dataSet following the formula:
     *
     * intercept = mean(y) - slope * mean(x)
     *
     * @return FormulasInterface
     * @throws MissingResultException
     */
    public function calculate(): FormulasInterface
    {
        try {
            $means = $this->previousResults->of(Mean::class);
            $slope = $this->previousResults->of(SimpleLinearSlope::class);
        } catch (\Throwable $exception) {
            throw new MissingResultException('Can not calculate the linear intercept without knowing the mean and the slope');
        }

        $this->result = $means[1][0] - ($slope * $means[0][0]);

        return $this;
    }
}
