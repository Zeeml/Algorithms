<?php

namespace Zeeml\Algorithms\Algorithms;

use Zeeml\Dataset\DatasetInterface;

interface AlgorithmsInterface
{
    public function train(DatasetInterface $dataset, float $learningRate = 0, AlgorithmsInterface $previous = null): AlgorithmsInterface;

    public function test(DatasetInterface $dataset);

    public function process($input);
}