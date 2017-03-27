<?php

namespace Zeeml\Algorithms;

use Zeeml\DataSet\DataSet;

interface AlgorithmsInterface
{
    public function fit(DataSet $data, float $learningRate = 0.0): AlgorithmsInterface;
    public function test(DataSet $data);
    public function process(float $data): float;
}