<?php

namespace RPGBundle\Service;

/**
 * Class TestService
 */
class SumService
{
    /**
     * @param float $a
     * @param float $b
     *
     * @return float
     */
    public function makeSum(float $a, float $b)
    {
        return $a + $b;
    }
}
