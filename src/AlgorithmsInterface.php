<?php

namespace Zeeml\Algorithms;

interface AlgorithmsInterface
{
    public function fit(array $data, float $learningRate = 0.0): AlgorithmsInterface;
}