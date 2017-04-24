<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait MeanCalculator
 * @package Zeeml\Algorithms\Traits
 */
trait MeanCalculator
{
    protected $means = [];

    /**
     * calculate the mean of the data sent
     * @param array $dataset
     * @return array
     */
    public function calculateMeans(array $dataset): array
    {
        $this->resetMeans();
        $datasetSize = count($dataset);

        foreach ($dataset as $row) {
            for ($key = 0; $key <= 1; $key++) {
                foreach ($row[$key] as $index => $input) {
                    $this->means[$key][$index] = $this->means[$key][$index]?? 0;
                    $this->means[$key][$index] += $input;
                }
            }
        }

        for ($key = 0; $key <= 1; $key++) {
            foreach ($this->means[$key] as $index => $input) {
                $this->means[$key][$index] /= $datasetSize;
            }
        }

        return $this->means;
    }

    public function getMeans(): array
    {
        return $this->means;
    }

    /**
     * resets the mean calculator by emptying the dimensions means and output means
     */
    public function resetMeans()
    {
        $this->means = [[], []];
    }
}