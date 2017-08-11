<?php

namespace RPGBehat;

use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext
{
    /**
     * @param string $sum
     *
     * @Then /Sum should be equals (?P<sum>\d+)/
     */
    public function thenSumShouldBeEquals($sum)
    {
        $response = $this->getSession()->getPage()->getContent();

        $json = json_decode($response, true);

        Assert::assertEquals($sum, $json['sum']);
    }
}
