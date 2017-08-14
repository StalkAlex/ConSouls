<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:19
 */

namespace RPGBundle\Service;


use RPGBundle\Action;
use RPGBundle\Domain\IAttackStrategy;
use RPGBundle\Entity\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;

/**
 * For MVP we create simple attack strategy that will produce random action for boss attack.
 * Later it could be extended to more complicated based on some boss/hero etc. characteristics
 * Class AttackStrategyService
 * @package RPGBundle\Service
 */
class SimpleAttackStrategyService implements IAttackStrategy
{
    /**
     * @param Boss $boss
     * @return null|AttackAction
     */
    public function getNextAction(Boss $boss)
    {
        $action = array_rand($boss->getActions(), 1);
        if (count($action) > 0) {
            return $action[0];
        }
        return null;
    }

    /**
     * @param Boss $boss
     * @param Hero $hero
     * @param AttackAction $attack
     * @param Action $defense
     */
    public function calculate(Boss $boss, Hero $hero, AttackAction $attack, Action $defense)
    {
        if ($this->isDefenseSuccessful($attack, $defense)) {
            $newHealth = $boss->getHealth() - $hero->getDamage();
            $boss->setHealth($newHealth);
        } else {
            $newHealth = $hero->getHealth() - $boss->getDamage();
            $hero->setHealth($newHealth);
        }
    }

    private function isDefenseSuccessful(AttackAction $attack, Action $defense)
    {
        return ($defense->getCode() === 'roll' && $attack->getIsRollable())
            || ($defense->getCode() === 'shield' && $attack->getIsBlockable());
    }
}