<?php

namespace Zeeml\Algorithms\Formulas;
use Zeeml\DataSet\DataSet;

/**
 * This class should be extended by all Formulas

 * abstract Class Calculator
 * @package Zeeml\AlgorithmsOld\Calculator
 */
abstract class Formulas implements FormulasInterface
{
    const EPSILON = 0.0000000001;

    /**
     * the dataSet to use
     * @var DataSet
     */
    protected $dataSet;

    /**
     * The results of the previous formulas
     * @var FormulasResults
     */
    protected $previousResults;

    /**
     * The result of the current formula
     * @var mixed
     */
    protected $result;

    /**
     * Specifies the dataSet on which to perform calculus
     * @param DataSet $dataSet
     * @return FormulasInterface
     */
    final public function using(DataSet $dataSet = null): FormulasInterface
    {
        $this->dataSet = $dataSet;

        return $this;
    }

    /**
     * Sets the previous result obtained from previous formulas to be used by this one
     * @param FormulasResults $results
     * @return FormulasInterface
     */
    final public function knowing(FormulasResults $results): FormulasInterface
    {
        $this->previousResults = $results;

        return $this;
    }

    /**
     * Returns the result of the calculate method
     * @return mixed
     */
    final public function getResult()
    {
        return $this->result;
    }
}
