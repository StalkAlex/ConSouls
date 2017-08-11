<?php

namespace Tests\RPGBundle\Service;

use PHPUnit\Framework\TestCase;
use RPGBundle\Service\SumService;

/**
 * Class SumServiceTest
 */
class SumServiceTest extends TestCase
{
    /**
     * Check sum service
     */
    public function testMakeSum()
    {
        $service = new SumService();

        self::assertEquals(5, $service->makeSum(2, 3));
    }
}
