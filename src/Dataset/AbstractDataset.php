<?php

namespace Zeeml\Algorithms\Dataset;

class AbstractDataset implements DatasetInterface
{
    protected $data;

    public function read()
    {

    }

    public function getData()
    {
        return $this->data;
    }
}

