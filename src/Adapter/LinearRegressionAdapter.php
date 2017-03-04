<?php

namespace Zeeml\Algorithms\Adapter;

use Zeeml\Algorithms\Dataset\DatasetInterface;

class LinearRegressionAdapter extends AbstractAdapter
{
    protected $intercept;
    protected $slope;

    /**
     * LinearRegressionAdapter constructor.
     * @param DatasetInterface $dataset
     */
    public function __construct(array $data)
    {
        $this->trainingData =  $data;
    }

    /**
     * prepares the data loaded in order to keep only two dimensional lines and sets keys to numerical
     * @return $this
     */
    public function prepare()
    {
        $this->trainingData = array_values(
            array_filter(
                $this->trainingData,
                function(& $line) {
                    $line = array_values($line);
                    return count($line) === 2;
                }
            )
        );

        return $this;
    }

    /**
     * functions that trains the data sent,
     * @return bool
     */
    public function train()
    {
        $this->prepare();

        $numberOfLines = count($this->trainingData);

        //Getting first dimension from each line
        $x = array_column($this->trainingData, 0);
        $y = array_column($this->trainingData, 1);
        $meanX = array_sum($x) / $numberOfLines;
        $meanY = array_sum($y) / $numberOfLines;

        $this->slope = 0;
        $denominator = 0;
        foreach ($this->trainingData as $line) {
            $xMinusMeanX = $line[0] - $meanX;
            $denominator += pow($xMinusMeanX, 2);
            $this->slope += ($xMinusMeanX) * ($line[1] - $meanY);
        }

        if ($denominator != 0) {
            $this->slope = $this->slope / $denominator;
        } else {
            $this->slope = 0;
        }

        $this->intercept = $meanY - ($this->slope * $meanX);

        return true;
    }

    /**
     * function that returns the prediction after the training
     * @param $input
     * @return float
     */
    public function predict($input)
    {
        return $this->intercept + $this->slope * $input;
    }

    /**
     * getter for slope
     * @return float
     */
    public function getSlope()
    {
        return $this->slope;
    }

    /**
     * getter for intercept
     * @return float
     */
    public function getIntercept()
    {
        return $this->intercept;
    }

}
