<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:18
 */

namespace RPGBundle\Service\Domain;

use RPGBundle\Entity\Action\AbstractAction;
use RPGBundle\Entity\Action\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;

/**
 * Main interface for the fight mechanics.
 * Interface AttackStrategyInterface
 */
interface AttackStrategyInterface
{
    /**
     * @param Boss $boss
     *
     * @return AttackAction
     */
    public function getNextAction(Boss $boss);

    /**
     * @param Boss           $boss
     * @param Hero           $hero
     * @param AttackAction   $attack
     * @param AbstractAction $defense
     *
     * @return void
     */
    public function calculate(Boss $boss, Hero $hero, AttackAction $attack, AbstractAction $defense);
}
