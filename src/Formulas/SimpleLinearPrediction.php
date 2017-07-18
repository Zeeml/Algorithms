<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\DataSet;
use Zeeml\Algorithms\Exceptions\MissingResultException;

class SimpleLinearPrediction extends Formulas
{
    protected $input;

    public function __construct(float $input = null)
    {
        $this->input = $input;
    }

    /**
     * the linear prediction is calculated for each input of the dataSet at a specific index using a slope and an intercept :
     *
     *    prediction = intercept + slope * input
     *
     * @return FormulasInterface
     * @throw CalculusResultNotFound
     * @throws MissingResultException
     */
    public function calculate(): FormulasInterface
    {
        try {
            $slope = $this->preRequisites->get(SimpleLinearSlope::class);
            $intercept = $this->preRequisites->get(SimpleLinearIntercept::class);
        }  catch (\Throwable $exception) {
            throw new MissingResultException('Can not calculate the linear prediction without knowing the slope and the intercept');
        }

        $this->result = $intercept + ($slope * $this->input);

        return $this;
    }
}