<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\DataSet\DataSet;

class Mean extends Formulas
{
    /**
     * calculate the mean of the dataSet
     * @return FormulasInterface
     * @throws WrongUsageException
     */
    public function calculate(): FormulasInterface
    {
        if (! $this->dataSet instanceof DataSet) {
            throw new WrongUsageException('DataSet was not provided for mean calculus');
        }

        $dataSetSize = $this->dataSet->size();
        $this->result = [];

        foreach ($this->dataSet as $instance) {
            foreach ($instance->dimensions() as $index => $dimension) {
                $this->result[0][$index] = $this->result[0][$index] ?? 0;
                $this->result[0][$index] += $dimension / $dataSetSize;
            }
            foreach ($instance->outputs() as $index => $output) {
                $this->result[1][$index] = $this->result[1][$index] ?? 0;
                $this->result[1][$index] += $output / $dataSetSize;
            }
        }

        return $this;
    }
}