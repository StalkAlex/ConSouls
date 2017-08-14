<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 15:18
 */

namespace RPGBundle\Service;


interface ICreatureFactory
{
    public function createBoss(string $name);
    public function createHero(string $name);
}