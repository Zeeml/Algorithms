<?php

namespace Zeeml\Algorithms\Adapter;

class AbstractAdapter implements AdapterInterface
{
    protected $trainingData;

    public function getTrainingData()
    {
        return $this->trainingData;
    }

    public function train()
    {
        // TODO: Implement train() method.
    }

    public function predicte()
    {
        // TODO: Implement predictœ() method.
    }
}

