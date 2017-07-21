<?php

namespace Zeeml\Algorithms;

use Zeeml\DataSet\DataSet;

interface AlgorithmsInterface
{
    public function fit(DataSet $dataSet, float $learningRate = 0.0): AlgorithmsInterface;
    public function test(DataSet $dataSet);
    public function process(DataSet $dataSet);
}