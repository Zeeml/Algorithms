<?php

namespace Zeeml\Algorithms;

use League\Csv\Reader;

class Dataset
{
    protected $data;
    
    protected $path;
    
    public function __construct($path = null)
    {
        $this->path = $path;
    }
    
    public function read()
    {
        if ($this->path) {
            $reader = Reader::createFromPath($this->path);
            $reader->stripBom(true);
            $reader->setOffset(1);
            $this->data = [];
            $reader->each(function($line) {
                $this->data[] = $line;
                return true;
            });
        }
        
        return $this;
    }
    
    public function getData()
    {
        return $this->data;
    }
}

