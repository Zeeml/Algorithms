<?php

namespace Zeeml\Algorithms\Tests\Fixtures;

use Zeeml\Algorithms\Formulas\Formulas;
use Zeeml\Algorithms\Formulas\FormulasInterface;

class Formula4 extends Formulas
{
    public function calculate(): FormulasInterface
    {
        $this->result = [];

        return $this;
    }
}