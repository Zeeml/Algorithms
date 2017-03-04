<?php

namespace Zeeml\Algorithms\Adapter;

interface AdapterInterface
{
    public function getTrainingData();

    public function train();

    public function predicte();
}

