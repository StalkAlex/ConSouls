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
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Entity\Creature\Knight;
use RPGBundle\Entity\Creature\Mage;
use RPGBundle\Exception\CreatureNotFoundException;

class CreatureFactoryService implements ICreatureFactory
{

    /**
     * @param string $name
     * @param array $actions
     * @return Hero
     * @throws CreatureNotFoundException
     */
    public function createHero(string $name, array $actions)
    {
        switch ($name) {
            case 'Knight':
                return new Knight($actions);
            case 'Mage':
                return new Mage($actions);
            default:
                throw new CreatureNotFoundException('Creature not found: ' . $name);
        }
    }

    /**
     * Now it will return one exact boss then logic could become more complicated
     * @return FireChampion
     */
    public function createBoss()
    {
        return new FireChampion([
            new Grasp(),
            new SwordAttack(),
            new FireStorm()
        ]);
    }
}