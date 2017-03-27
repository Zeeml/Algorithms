<?php

namespace Zeeml\Algorithms\Formulas;

use Zeeml\DataSet\DataSet;

interface FormulasInterface
{
    public function using(DataSet $dataSet = null): FormulasInterface;

    public function knowing(FormulasResults $results): FormulasInterface;

    public function calculate(): FormulasInterface;

    public function getResult();
}