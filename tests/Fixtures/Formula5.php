<?php

namespace Zeeml\Algorithms\Tests\Fixtures;

use Zeeml\Algorithms\Formulas\Formulas;
use Zeeml\Algorithms\Formulas\FormulasInterface;

class Formula5 extends Formulas
{
    public function calculate(): FormulasInterface
    {
        $this->result = 'hello';
        
        return $this;
    }
}