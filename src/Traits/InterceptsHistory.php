<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait InterceptsHistory
 * @package Zeeml\Algorithms\Traits
 */
trait InterceptsHistory
{
    protected $interceptsHistory = [];

    /**
     * @return array
     */
    public function getInterceptsHistory(): array
    {
        return $this->interceptsHistory;
    }

    /**
     * resets the interceptCalculator by setting the intercept to 0
     */
    public function resetInterceptsHistory()
    {
        $this->interceptsHistory = [];
    }
}