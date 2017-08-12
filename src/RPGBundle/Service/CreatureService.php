<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 19:27
 */

namespace RPGBundle\Service;


use RPGBundle\Component\CreatureFactory;

class CreatureService
{
    /** @var CreatureFactory $creatureFactory */
    private $creatureFactory;

    public function __construct(CreatureFactory $creatureFactory)
    {
        $this->creatureFactory = $creatureFactory;
    }

    public function GetAvailableHeroes(): array
    {
        return $this->creatureFactory->getHeroes();
    }
}