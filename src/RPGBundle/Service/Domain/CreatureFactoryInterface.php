<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 15:18
 */

namespace RPGBundle\Service\Domain;

use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;

/**
 * Working with creature instances
 * Interface CreatureFactoryInterface
 */
interface CreatureFactoryInterface
{
    /**
     * @param string $name
     * @param array  $actions
     *
     * @return Hero
     */
    public function createHero(string $name, array $actions);

    /**
     * @return Boss
     */
    public function createBoss();
}
