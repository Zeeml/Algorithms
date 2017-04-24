<?php

namespace Zeeml\Algorithms\Traits;

/**
 * trait InterceptCalculator that calculates an intercept
 * @package Zeeml\Algorithms\Traits
 */
trait SlopesHistory
{
    protected $slopesHistory = [];

    /**
     * @return array
     */
    public function getSlopesHistory(): array
    {
        return $this->slopesHistory;
    }

    /**
     * Resets the slopes history
     */
    public function resetSlopesHistory()
    {
        $this->slopesHistory = [];
    }
}