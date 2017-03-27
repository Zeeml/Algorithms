<?php

namespace Zeeml\Algorithms\Tests\Fixtures;

use Zeeml\Algorithms\Formulas\Formulas;
use Zeeml\Algorithms\Formulas\FormulasInterface;

class Formula3 extends Formulas
{
    public function calculate(): FormulasInterface
    {
        return $this;
    }
}