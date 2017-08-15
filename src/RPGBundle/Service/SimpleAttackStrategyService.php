<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:19
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action\AbstractAction;
use RPGBundle\Entity\Action\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\AbstractCreature;
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Exception\CharacterInsufficientActionException;
use RPGBundle\Service\Domain\AttackStrategyInterface;

/**
 * For MVP we create simple attack strategy.
 * It will produce random actions for boss attacks.
 * Also it return successful result if player choose roll for rollable boss attack, or shield - for blockable.
 * Later it could be extended to more complicated logic based on some boss/hero etc. characteristics
 * Class AttackStrategyService
 */
class SimpleAttackStrategyService implements AttackStrategyInterface
{
    /**
     * Returns next attack for boss during fight process.
     * Normally it supposed to consider some player statistics to make fight more interesting.
     * For MVP simplicity it will return random action.
     *
     * @param Boss $boss
     *
     * @return AttackAction
     *
     * @throws CharacterInsufficientActionException
     */
    public function getNextAction(Boss $boss)
    {
        $actions = $boss->getActions();
        if (empty($actions)) {
            throw new CharacterInsufficientActionException(sprintf('Boss doesn\'t have actions to perform', $boss->getName()));
        }
        $key = array_rand($actions, 1);

        return $actions[$key];
    }

    /**
     * Recalculates player statistics whether attack was successful or not.
     *
     * @param Boss           $boss
     * @param Hero           $hero
     * @param AttackAction   $attack
     * @param AbstractAction $defense
     */
    public function calculate(Boss $boss, Hero $hero, AttackAction $attack, AbstractAction $defense)
    {
        if ($this->isDefenseSuccessful($attack, $defense)) {
            $this->updateHealth($boss, $hero);
        } else {
            $this->updateHealth($hero, $boss);
        }
    }

    /**
     * @param AttackAction   $attack
     * @param AbstractAction $defense
     *
     * @return bool
     */
    private function isDefenseSuccessful(AttackAction $attack, AbstractAction $defense)
    {
        return ($defense->getCode() === 'roll' && $attack->getIsRollable())
            || ($defense->getCode() === 'shield' && $attack->getIsBlockable());
    }

    /**
     * @param AbstractCreature $creature1
     * @param AbstractCreature $creature2
     */
    private function updateHealth(AbstractCreature $creature1, AbstractCreature $creature2)
    {
        $newHealth = $creature1->getHealth() - $creature2->getDamage();
        if ($newHealth < 0) {
            $newHealth = 0;
        }
        $creature1->setHealth($newHealth);
    }
}
