<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 19:27
 */

namespace RPGBundle\Service;

/**
 * Class CreatureService
 * @package RPGBundle\Service
 */
class CreatureService
{
    /** @var CreatureFactoryService $creatureFactory */
    private $creatureFactory;

    public function __construct(CreatureFactoryService $creatureFactory)
    {
        $this->creatureFactory = $creatureFactory;
    }

    public function getAvailableHeroes(): array
    {
        return $this->creatureFactory->getHeroes();
    }

    public function getHero(string $name)
    {
        return $this->creatureFactory->createHero($name);
    }
}