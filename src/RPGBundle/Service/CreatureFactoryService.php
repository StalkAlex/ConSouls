<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 21:27
 */

namespace RPGBundle\Service;


use RPGBundle\Entity\Action\FireStorm;
use RPGBundle\Entity\Action\Grasp;
use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Action\SwordAttack;
use RPGBundle\Entity\Creature\Boss\FireChampion;
use RPGBundle\Entity\Creature\Knight;
use RPGBundle\Entity\Creature\Mage;
use RPGBundle\Exception\CreatureNotFoundException;

class CreatureFactoryService implements ICreatureFactory
{

    /**
     * @param string $name
     * @return Knight|Mage
     * @throws CreatureNotFoundException
     */
    public function createHero(string $name)
    {
        switch ($name) {
            case 'Knight':
                return new Knight($this->getDefaultHeroActions());
            case 'Mage':
                return new Mage($this->getDefaultHeroActions());
            default:
                throw new CreatureNotFoundException('Creature not found: ' . $name);
        }
    }

    /**
     * Now it will return one exact boss then logic could become more complicated
     * @return FireChampion
     */
    public function createBoss(string $name)
    {
        return new FireChampion([
            new Grasp(),
            new SwordAttack(),
            new FireStorm()
        ]);
    }

    /**
     * Returns all available heroes in the game.
     * For a simplicity it will return hardcoded instance, later it could be configured outside
     * @return array
     */
    public function getHeroes()
    {
        return [
            new Knight($this->getDefaultHeroActions()),
            new Mage($this->getDefaultHeroActions())
        ];

    }

    protected function getDefaultHeroActions()
    {
        return [new Roll(), new Shield()];
    }
}