<?php

namespace Zeeml\Algorithms;

use Zeeml\Algorithms\Math\InterceptCalculator;
use Zeeml\Algorithms\Math\MeanCalculator;
use Zeeml\Algorithms\Math\SlopeCalculator;

/**
 * Class LinearRegression
 * class that trains a set of data following the linear regression method
 * @package Zeeml\Algorithms\Adapter
 */
trait SimpleLinearRegression
{
    use MeanCalculator;
    use SlopeCalculator;
    use InterceptCalculator;


    /**
     * functions that trains the data sent,
     * @return bool
     */
    public function train(): PredictionInterface
    {
        /*if (!$this->isPrepared) {
            $this->prepare();
        }*/
        $this->isTrained = true;
        //calculate the means of each input and eac (MeanCalculator)
        $this->calculateMeans($this->dataset);
        //based on both means, calculate the slope
        $this->calculateSlope($this->dataset, 0, 0, $this->getMeanInputAt(0), $this->getMeanOutputAt(0));
        //And calculate the intercept
        $this->calculateIntercept($this->getSlope(), $this->getMeanInputAt(0), $this->getMeanOutputAt(0));
        //update the dataset with all the calculated info
        return $this;
    }

}
