<?php

namespace Zeeml\Algorithms\Tests\Formulas;

use PHPUnit\Framework\TestCase;
use Zeeml\Algorithms\Exceptions\CalculusResultNotFound;
use Zeeml\Algorithms\Formulas\FormulasResults;
use Zeeml\Algorithms\Tests\Fixtures\Formula1;
use Zeeml\Algorithms\Tests\Fixtures\Formula2;
use Zeeml\Algorithms\Tests\Fixtures\Formula3;
use Zeeml\Algorithms\Tests\Fixtures\Formula4;
use Zeeml\Algorithms\Tests\Fixtures\Formula5;

class FormulasResultsTest extends TestCase
{
    protected $formula1;
    protected $formula2;
    protected $formula3;
    protected $formula4;
    protected $formula5;

    public function setUp()
    {
        parent::setUp();
        $this->formula1 = (new Formula1())->calculate();
        $this->formula2 = (new Formula2())->calculate();
        $this->formula3 = (new Formula3())->calculate();
        $this->formula4 = (new Formula4())->calculate();
        $this->formula5 = (new Formula5())->calculate();
    }

    public function testGetAll()
    {
        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula1);
        $formulaResults->save($this->formula2);
        $formulaResults->save($this->formula3);
        $formulaResults->save($this->formula4);
        $formulaResults->save($this->formula5);

        $this->assertEquals(
            $formulaResults->getAll(),
            [
                Formula1::class => 1,
                Formula2::class => 2,
            ]
        );
    }

    public function testGetLast()
    {
        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula1);
        $formulaResults->save($this->formula2);

        $this->assertEquals(
            $formulaResults->getLast(),
            2
        );

        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula1);
        $formulaResults->save($this->formula2);
        $formulaResults->save($this->formula3);
        $formulaResults->save($this->formula4);
        $formulaResults->save($this->formula5);

        $this->assertEquals(
            $formulaResults->getLast(),
            2
        );
    }

    public function testGetException()
    {
        $this->expectException(CalculusResultNotFound::class);

        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula1);
        $formulaResults->get('test');
    }

    public function testGetException2()
    {
        $this->expectException(CalculusResultNotFound::class);

        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula3);
        $formulaResults->get(Formula3::class);
    }

    public function testGetException3()
    {
        $this->expectException(CalculusResultNotFound::class);

        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula4);
        $formulaResults->get(Formula4::class);
    }

    public function testGetException4()
    {
        $this->expectException(CalculusResultNotFound::class);

        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula5);
        $formulaResults->get(Formula5::class);
    }

    public function testGet()
    {
        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula1);
        $formulaResults->save($this->formula2);

        $this->assertEquals($formulaResults->get(Formula1::class), 1);
        $this->assertEquals($formulaResults->get(Formula2::class), 2);
    }

    public function testSave()
    {
        $formulaResults = new FormulasResults();
        $formulaResults->save($this->formula1);
        $formulaResults->save($this->formula2);
        $formulaResults->save($this->formula3);
        $formulaResults->save($this->formula4);
        $formulaResults->save($this->formula5);
        $formulaResults->save($this->formula1);

        $this->assertEquals($formulaResults->getAll(), [Formula1::class => 1, Formula2::class => 2]);
    }

    public function testIsValid()
    {
        $formulaResults = new FormulasResults();
        $this->assertTrue($formulaResults->isValid($this->formula1));
        $this->assertTrue($formulaResults->isValid($this->formula2));
        $this->assertFalse($formulaResults->isValid($this->formula3));
        $this->assertFalse($formulaResults->isValid($this->formula4));
        $this->assertFalse($formulaResults->isValid($this->formula5));

    }

    public function testReset()
    {
        $formulaResults = new FormulasResults();
        $this->assertEquals($formulaResults->getAll(), []);

        $formulaResults->save($this->formula1);
        $this->assertEquals($formulaResults->getAll(), [Formula1::class => 1]);

        $formulaResults->reset();
        $this->assertEquals($formulaResults->getAll(), []);
    }
}