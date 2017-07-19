<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\Exceptions\CalculusResultNotFound;

class FormulasResults
{
    protected $results = [];
    protected $stack;

    /**
     * return all the results stored in
     * @return mixed
     */
    public function getAll()
    {
        return $this->results;
    }

    /**
     * Gets the last result stored
     * @return mixed
     */
    public function last()
    {
        return end($this->results);
    }

    /**
     * Returns a specific result by key
     * @param string $formulaName
     * @return mixed
     * @throws CalculusResultNotFound
     */
    public function of(string $formulaName)
    {
        if (! isset($this->results[$formulaName])) {
            throw new CalculusResultNotFound('No result found for the given formula : ' . $formulaName );
        }

        return $this->results[$formulaName];
    }

    /**
     * Save the results of a given formula to keep in the history
     * @param FormulasInterface $formula
     * @return FormulasResults
     */
    public function save(FormulasInterface $formula): FormulasResults
    {
        if ($this->isValid($formula)) {
            $this->results[get_class($formula)] = $formula->getResult();
        }

        //the stack contains all the formulas called (a callstack)
        $this->stack[] = $formula;

        return $this;
    }

    /**
     * Validates the formula by validating the result
     * A formula is not valid if the result is : null, an empty array or not a float
     * @param FormulasInterface $formula
     * @return bool
     */
    public function isValid(FormulasInterface $formula): bool
    {
        $result = $formula->getResult();

        if ((is_array($result) && count($result) > 0) || is_numeric($result)) {
            return true;
        }

        return false;
    }

    /**
     * Resets the results to empty the history
     * @return FormulasResults
     */
    public function reset(): FormulasResults
    {
        $this->results = [];

        return $this;
    }
}