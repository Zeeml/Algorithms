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
        $this->reset();
        $datasetSize = count($dataset);

        /*
         * takes 0.17172408103943 seconds
         * foreach ($dataset as &$row) {
            $this->means[0] = array_map(
                function (...$arrays) {
                    return array_sum($arrays);
                },
                $row[0],
                $this->means[0]
            );

            $this->means[1] = array_map(
                function (...$arrays) {
                    return array_sum($arrays);
                },
                $row[1],
                $this->means[1]
            );
        }

        array_walk_recursive(
            $this->means,
            function(&$data) use ($datasetSize)  {
                $data = $data / $datasetSize;
            }
        ); */

        /*
         * 0.085626125335693 seconds
        foreach ($dataset as $row) {
            for ($key = 0; $key <= 1; $key++) {
                foreach ($row[$key] as $index => $input) {
                    $this->means[$key][$index] = $this->means[$key][$index]?? 0;
                    $this->means[$key][$index] += $input;
                }
            }
        }

        array_walk_recursive(
            $this->means,
            function(&$data) use ($datasetSize)  {
                $data = $data / $datasetSize;
            }
        ); */

        //0.084634065628052 seconds

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
    public function reset()
    {
        $this->means = [ [], []];
    }
}