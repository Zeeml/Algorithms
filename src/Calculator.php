<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Formulas\FormulasInterface;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\DataSet\DataSet;

/**
 * This class is used as a maestro for the formulas classes
 * It is an enhanced proxy to the formulas classes
 * Using this calculator, you can execute multiple formulas in a row :
 *
 * (new Calculator($dataSet))
 *     ->calculate(new Formula1())
 *     ->then(new Formula2())
 *     ->then(new Formula3())
 *     ...
 *     ->getResults()
 *     ->last()
 *
 * Class Calculator
 * @package Zeeml\Algorithms
 */
class Calculator
{
    protected $dataSet;

    /**
     * constructs takes in the dataSet on which to perform the calculus
     */
    public function __construct()
    {
        $this->results = new FormulasResults();
    }

    /**
     * if one of the formulas needs the dataSet, this function transmits the dataSet to the formulas
     * @param DataSet $dataSet
     * @return Calculator
     */
    public function using(DataSet $dataSet): Calculator
    {
        $this->dataSet = $dataSet;

        return $this;
    }

    /**
     * Starts a new calculus using the formula sent.
     * It resets the calculus by emptying the history of calls
     *
     * @param FormulasInterface $formula
     * @return Calculator
     */
    public function calculate(FormulasInterface $formula): Calculator
    {
        $formula
            ->using($this->dataSet)
            ->knowing($this->results)
            ->calculate();

        $this->results->save($formula);

        return $this;
    }

    /**
     * Chains the calculation to a previous one (previous calculate or previous then)
     * it is  a proxy for the calculate method used solely to propose a user friendly experience
     *
     * @param FormulasInterface $formula
     * @return Calculator
     * @throws WrongUsageException
     */
    public function then(FormulasInterface $formula): Calculator
    {
        return $this->calculate($formula);
    }


    /**
     * Gets the results of all the formulas called
     * @return FormulasResults
     */
    public function getResult(): FormulasResults
    {
        return $this->results;
    }
}
