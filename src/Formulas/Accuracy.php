<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\Algorithms\DataSet;
use Zeeml\Algorithms\Specification\DataSetRowHasOutputs;
use Zeeml\Algorithms\Specification\DataSetRowHasPredictions;
use Zeeml\Algorithms\Specification\IsPredictionCorrect;
use Zeeml\Algorithms\Specification\PredictionExists;

/**
 * class that contains the functions used to calculate the accuracy of an algorithm
 * @package Zeeml\Algorithms\Traits
 */
class Accuracy extends Formulas
{
    /**
     * calculates the accuracy of the predictions made on a dataSet using the last result calculated :
     * Two conditions must be met :
     *
     *  - The dataSet must contain the predictions
     *  - The array of predictions must have the same size as the dataSet
     *
     * If any of the above conditions is missing, the accuracy is 0
     *
     *
     *                         NumberOfCorrectGuesses
     *          accuracy =   -------------------------
     *                            NumberOfOutputs
     *
     * @return FormulasInterface
     */
    public function calculate(): FormulasInterface
    {
        $dataSetRowHasOutputs = new DataSetRowHasOutputs();
        $dataSetRowHasPredictions = new DataSetRowHasPredictions();
        $predictionExist = new PredictionExists();
        $isPredictionCorrect = new IsPredictionCorrect();

        $dataSetSize = $this->getDataSetSize();

        $correctGuesses = 0;
        foreach ($this->dataSet as &$row) {
            if (! ($dataSetRowHasOutputs->and($dataSetRowHasPredictions))->isSatisfiedBy($row)) {
                $dataSetSize--;
                continue;
            }
            foreach ($row[DataSet::OUTPUTS_INDEX] as $index => $output) {
                if ( !$predictionExist->isSatisfiedBy($row, $index)) {
                    $dataSetSize--;
                    continue;
                }
                if ($isPredictionCorrect->isSatisfiedBy($row, $index)) {
                    $correctGuesses++;
                }
            }
        }

        return $correctGuesses / $dataSetSize;
    }
}
