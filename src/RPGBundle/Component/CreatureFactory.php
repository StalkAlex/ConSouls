<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 21:27
 */

namespace RPGBundle\Component;


use RPGBundle\Entity\Creature\Knight;
use RPGBundle\Entity\Creature\Mage;
use RPGBundle\Exception\CreatureNotFoundException;

class CreatureFactory
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
                return new Knight();
            case 'Mage':
                return new Mage();
            default:
                throw new CreatureNotFoundException('Creature not found: ' . $name);
        }
    }

    public function getHeroes()
    {
        return [
            new Knight(),
            new Mage()
        ];

    }
}