<?php

namespace Zeeml\Algorithms\Tests\Fixtures;

use Zeeml\Algorithms\Formulas\Formulas;
use Zeeml\Algorithms\Formulas\FormulasInterface;

class Formula2 extends Formulas
{
    public function calculate(): FormulasInterface
    {
        $this->result = 2;

        return $this;
    }
}