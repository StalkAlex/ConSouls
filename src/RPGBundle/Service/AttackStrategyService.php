<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 14.08.2017
 * Time: 16:19
 */

namespace RPGBundle\Service;


use RPGBundle\Domain\IAttackStrategy;
use RPGBundle\Entity\AttackAction;
use RPGBundle\Entity\Creature\Boss;

/**
 * For MVP we create simple attack strategy that will produce random action for boss attack.
 * Later it could be extended to more complicated based on some boss/hero etc. characteristics
 * Class AttackStrategyService
 * @package RPGBundle\Service
 */
class AttackStrategyService implements IAttackStrategy
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
}