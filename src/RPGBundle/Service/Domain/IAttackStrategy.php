<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:18
 */

namespace RPGBundle\Service\Domain;


use RPGBundle\Entity\Action;
use RPGBundle\Entity\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;

/**
 * Main interface for the fight mechanics.
 * Interface IAttackStrategy
 * @package RPGBundle\Service\Domain
 */
interface IAttackStrategy
{
    public function getNextAction(Boss $boss);
    public function calculate(Boss $boss, Hero $hero, AttackAction $attack, Action $defense);
}