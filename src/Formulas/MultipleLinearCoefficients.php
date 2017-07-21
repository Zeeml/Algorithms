<?php

namespace Zeeml\Algorithms\Formulas;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\Exception\SingularMatrixException;
use NumPHP\LinAlg\LinAlg;
use Zeeml\Algorithms\Exceptions\AlgorithmNotApplicable;
use Zeeml\Algorithms\Exceptions\MissingResultException;
use Zeeml\Algorithms\Exceptions\WrongUsageException;
use Zeeml\DataSet\DataSet;

class MultipleLinearCoefficients extends Formulas
{
    /**
     * Calculating the coefficients (slopes and intercept) of the dataSet following the formula:
     *
     *    y1 = B0 * 1 + B1 * X11 + B2 * X21 + ...
     *    y2 = B0 * 1 + B1 * X12 + B2 * X22 + ...
     *
     *          [                         [                               [
     *            y1                        1 X11 X21 ...                   B0
     *    So Y =  y2          and     X =   1 X21 X22 ...     and Coeffs =  B1
     *            ...                       1 ...                           B2
     *          ]                         ]                                 ...
     *                                                                    ]
     *   Then
     *
     *        coeffs = ((X'.X)^-1).(X'.Y)
     *
     *
     *  Where X' is the transposed matrix of X
     *  ^-1 is the inverse of matrix X (if the matrix can be inverted)
     *  . (dot) is the multiplication sign for matrices
     *
     * @return FormulasInterface
     * @throws MissingResultException
     * @throws WrongUsageException
     * @throws AlgorithmNotApplicable
     */
    public function calculate(): FormulasInterface
    {
        if (! $this->dataSet instanceof DataSet) {
            throw new WrongUsageException('DataSet was not provided for slope calculus');
        }

        try {
            $dimensions = $this->dataSet->getRawDimensions();
            array_walk(
                $dimensions,
                function(&$row) {
                    array_unshift($row, 1);
                }
            );
            $x = new NumArray($dimensions);
            $y = new NumArray($this->dataSet->getRawOutputs());

            $xTransposed = $x->getTranspose();
            $inverse = LinAlg::inv((clone $xTransposed)->dot($x));
            $xTransposedY = (clone $xTransposed)->dot($y);
            $data = ($inverse->dot($xTransposedY))->getData();

            $this->result = [];
            array_walk_recursive($data, function ($elem) {
                $this->result[] = $elem;
            });
        } catch (SingularMatrixException $e) {
            $this->result = [];
            throw new AlgorithmNotApplicable('Can not use multiple linear regression for the given data');
        }

        return $this;
    }
}