<?php

namespace Zeeml\Algorithms\Formulas;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\DataSet\DataSet;

/**
 * class that contains the functions used to calculate the accuracy of an algorithm
 * @package Zeeml\Algorithms\Traits
 */
class Rmse extends Formulas
{
    protected $algorithmName;

    public function __construct(string $algorithmName)
    {
        $this->algorithmName = $algorithmName;
    }

    /**
     * calculates the accuracy of the predictions made on a dataSet using the last result calculated :
     * Two conditions must be met :
     *
     *  - The dataSet must contain the predictions
     *  - The array of predictions must have the same size as the dataSet
     *
     * If any of the above conditions is missing, the accuracy is 0

     * @return FormulasInterface
     * @throws WrongUsageException
     */
    public function calculate(): FormulasInterface
    {
        if (! $this->dataSet instanceof DataSet) {
            throw new WrongUsageException('DataSet was not provided for Accuracy calculus');
        }

        $rmse = 0;

        foreach ($this->dataSet as $instance) {
            $result = $instance->getResult($this->algorithmName);

            if (! isset($result['result'])) {
                throw new WrongUsageException('Can not calculate accuracy before testing the dataSet');
            }


        }

        $this->result = $rmse / $this->dataSet->getSize();

        return $this;
    }
}
