<?php

namespace Zeeml\Algorithms\Formulas;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\DataSet\DataSet;

/**
 * class that contains the functions used to calculate the accuracy of an algorithm
 * @package Zeeml\Algorithms\Traits
 */
class Benchmark extends Formulas
{
    protected $algorithmName;
    const ACCURACY = 'accuracy';
    const RMSE = 'rmse';

    public function __construct(string $algorithmName)
    {
        $this->algorithmName = $algorithmName;
    }

    /**
     * calculates the accuracy and the RMSE for a dataSet after the fit and test are done :
     *
     *
     *                         NumberOfCorrectGuesses
     *          accuracy =   -------------------------
     *                            NumberOfOutputs
     *
     *  and
     *                        Σ (prediction - output)^2
     *          Rmse =        -------------------------
     *                             NumberOfOutputs
     *
     *
     * @return FormulasInterface
     * @throws WrongUsageException
     */
    public function calculate(): FormulasInterface
    {
        if (! $this->dataSet instanceof DataSet) {
            throw new WrongUsageException('DataSet was not provided for Accuracy calculus');
        }

        $correctGuesses = 0;
        $rmse = 0;

        foreach ($this->dataSet as $instance) {
            $result = $instance->result($this->algorithmName);

            if (! isset($result['result'])) {
                throw new WrongUsageException('Can not calculate accuracy before testing the dataSet');
            }

            if (abs($result['result'] - $instance->output(0)) <= self::EPSILON ) {
                $correctGuesses ++;
            }

            $rmse += pow($result['result'] - $instance->output(0), 2);
        }

        $accuracy = $correctGuesses / $this->dataSet->size();
        $rmse = sqrt($rmse / $this->dataSet->size());

        $this->result = [self::ACCURACY => $accuracy, self::RMSE => $rmse];

        return $this;
    }
}
