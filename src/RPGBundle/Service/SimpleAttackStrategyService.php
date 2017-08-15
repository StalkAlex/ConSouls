<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:19
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action;
use RPGBundle\Entity\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Creature;
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Service\Domain\IAttackStrategy;

/**
 * For MVP we create simple attack strategy.
 * It will produce random actions for boss attacks.
 * Also it return successful result if player choose roll for rollable boss attack, or shield - for blockable.
 * Later it could be extended to more complicated logic based on some boss/hero etc. characteristics
 * Class AttackStrategyService
 * @package RPGBundle\Service
 */
class SimpleAttackStrategyService implements IAttackStrategy
{
    /**
     * Returns next attack for boss during fight process.
     * Normally it supposed to consider some player statistics to make fight more interesting.
     * For MVP simplicity it will return random action
     * @param Boss $boss
     * @return null|AttackAction
     */
    public function getNextAction(Boss $boss)
    {
        $actions = $boss->getActions();
        if (empty($actions)) {
            return null;
        }
        $key = array_rand($actions, 1);
        return $actions[$key];
    }

    /**
     * Recalculates player statistics whether attack was successful or not.
     * @param Boss         $boss
     * @param Hero         $hero
     * @param AttackAction $attack
     * @param Action       $defense
     */
    public function calculate(Boss $boss, Hero $hero, AttackAction $attack, Action $defense)
    {
        if ($this->isDefenseSuccessful($attack, $defense)) {
            $this->updateHealth($boss, $hero);
        } else {
            $this->updateHealth($hero, $boss);
        }
    }

    /**
     * @param AttackAction $attack
     * @param Action       $defense
     * @return bool
     */
    private function isDefenseSuccessful(AttackAction $attack, Action $defense)
    {
        return ($defense->getCode() === 'roll' && $attack->getIsRollable())
            || ($defense->getCode() === 'shield' && $attack->getIsBlockable());
    }

    /**
     * @param Creature $creature1
     * @param Creature $creature2
     */
    private function updateHealth(Creature $creature1, Creature $creature2)
    {
        $newHealth = $creature1->getHealth() - $creature2->getDamage();
        if ($newHealth < 0) {
            $newHealth = 0;
        }
        $creature1->setHealth($newHealth);
    }
}
