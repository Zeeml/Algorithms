<?php

namespace Zeeml\Algorithms\Tests\Fixtures;

use Zeeml\Algorithms\Formulas\Formulas;
use Zeeml\Algorithms\Formulas\FormulasInterface;

class Formula1 extends Formulas
{
    public function calculate(): FormulasInterface
    {
        $this->result = 1;

        return $this;
    }
}