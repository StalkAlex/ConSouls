<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:18
 */

namespace RPGBundle\Domain;


use RPGBundle\Entity\Creature\Boss;

interface IAttackStrategy
{
    public function getNextAction(Boss $boss);
}