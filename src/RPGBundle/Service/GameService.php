<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 15:21
 */

namespace RPGBundle\Service;


use RPGBundle\Domain\IAttackStrategy;
use RPGBundle\Entity\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Exception\NoActionDefinedException;

class GameService
{
    /** @var  IAttackStrategy */
    private $attackStrategyService;

    public function __construct(IAttackStrategy $attackStrategyService)
    {
        $this->attackStrategyService = $attackStrategyService;

    }

    /**
     * @param Boss $boss
     * @return AttackAction
     * @throws NoActionDefinedException
     */
    public function getBossAttack(Boss $boss)
    {
        $action = $this->attackStrategyService->getNextAction($boss);
        if (!$action) {
            throw new NoActionDefinedException('There are no defined actions for boss instance');
        }
        return $action;
    }
}