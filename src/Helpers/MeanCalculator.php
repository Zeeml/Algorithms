<?php

namespace Zeeml\Algorithms\Helpers;

use Zeeml\Algorithms\Exceptions\EmptyDatasetException;
use Zeeml\Algorithms\Exceptions\IndexNotFoundException;
use Zeeml\Dataset\Dataset;
use Zeeml\Dataset\DatasetInterface;

trait MeanCalculator
{
    protected $meanInputs = [];
    protected $meanOutputs = [];

    /**
     * calculates the mean of all inputs and outputs of a dataset following the formula:
     *                             Σx        x1     x2     x3
     *  for each input/output :   ---  <=>  ---  + --- +  ---  ....
     *                             n         n      n      n
     * and stores them in array $meanInputs and array $meanOutputs keeping the indexes matched
     * @param Dataset $dataset
     * @return bool
     * @throws EmptyDatasetException
     */
    public function calculateMeans(DatasetInterface $dataset): bool
    {
        //calculating the number of istannces
        $numberOfLines = count($dataset->instances());
        //if no line throw an exception
        if ($numberOfLines === 0) {
            throw new EmptyDatasetException('Dataset seems to be empty. Could not calculate the means');
        }
        //calculating the sums of each input and each output to prepare the mean
        foreach ($dataset as $instance) {
            //going through all inputs of this dataset
            foreach ($instance->inputs() as $index => $input) {
                //calculating the mean of this input and storing it in meanInputs at the same index as the input
                $this->meanInputs[$index] = $this->meanInputs[$index]?? 0;
                $this->meanInputs[$index] += $input / $numberOfLines;
            }
            //going through all outputs of this dataset
            foreach ($instance->outputs() as $index => $output) {
                //calculating the mean of this output and storing it in meanOutputs at the same index as the output
                $this->meanOutputs[$index] = $this->meanOutputs[$index]?? 0;
                $this->meanOutputs[$index] += $output / $numberOfLines;
            }
        }

        return true;
    }

    /**
     * returns all the means of all the inputs
     * @return array
     */
    public function getMeanInputs(): array
    {
        return $this->meanInputs;
    }

    /**
     * returns all the means of all the outputs
     * @return array
     */
    public function getMeanOutputs(): array
    {
        return $this->meanOutputs;
    }

    /**
     * return a specific mean of an input at a specific index
     * @param int $index
     * @return float
     * @throws IndexNotFoundException
     */
    public function getMeanInputAt(int $index): float
    {
        if (isset($this->meanInputs[$index])) {
            return $this->meanInputs[$index];
        }

        throw new IndexNotFoundException('Mean of input at index ' . $index . ' not found');
    }

    /**
     * return a specific mean of an output at a specific index
     * @param int $index
     * @return float
     * @throws IndexNotFoundException
     */
    public function getMeanOutputAt(int $index): float
    {
        if (isset($this->meanOutputs[$index])) {
            return $this->meanOutputs[$index];
        }

        throw new IndexNotFoundException('Mean of output at index ' . $index . ' not found');
    }
}