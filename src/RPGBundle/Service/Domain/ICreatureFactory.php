<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 15:18
 */

namespace RPGBundle\Service\Domain;

/**
 * Working with creature instances
 * Interface ICreatureFactory
 * @package RPGBundle\Service\Domain
 */
interface ICreatureFactory
{
    public function createHero(string $name, array $actions);
    public function createBoss();
}
