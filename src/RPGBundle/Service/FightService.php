<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 15:21
 */

namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Action\AbstractAction;
use RPGBundle\Entity\Action\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Entity\Profile;
use RPGBundle\Exception\CharacterInsufficientActionException;
use RPGBundle\Exception\NoActionDefinedException;
use RPGBundle\Service\Domain\AttackStrategyInterface;
use RPGBundle\Service\Domain\CreatureFactoryInterface;

/**
 * Class FightService
 */
class FightService
{
    /** @var  AttackStrategyInterface */
    private $attackStrategyService;
    /** @var CreatureFactoryService $creatureFactory */
    private $creatureFactory;
    /** @var  ActionService $actionService */
    private $actionService;
    /** @var  EntityManager $manager */
    private $manager;

    /**
     * FightService constructor.
     *
     * @param AttackStrategyInterface  $attackStrategyService
     * @param CreatureFactoryInterface $creatureFactory
     * @param ActionService            $actionService
     * @param EntityManager            $manager
     */
    public function __construct(AttackStrategyInterface $attackStrategyService, CreatureFactoryInterface $creatureFactory, ActionService $actionService, EntityManager $manager)
    {
        $this->attackStrategyService = $attackStrategyService;
        $this->creatureFactory = $creatureFactory;
        $this->actionService = $actionService;
        $this->manager = $manager;
    }

    /**
     * Returns all available heroes in the game.
     * For a simplicity it will return hardcoded instance, later it could be configured outside.
     *
     * @return array
     */
    public function getAvailableHeroes()
    {
        return [
            $this->getHero('Knight'),
            $this->getHero('Mage'),
        ];
    }

    /**
     * @return array
     *
     * @throws NoActionDefinedException
     */
    public function getHeroActions()
    {
        return $this->actionService->getAvailableDefenseActions();
    }

    /**
     * @param string $name
     *
     * @return Hero
     *
     * @throws NoActionDefinedException
     */
    public function getHero(string $name)
    {
        return $this->creatureFactory->createHero($name, $this->actionService->getAvailableDefenseActions());
    }

    /**
     * @param string $code
     *
     * @return AbstractAction
     *
     * @throws NoActionDefinedException
     */
    public function getAction(string $code)
    {
        return $this->actionService->getAction($code);
    }

    /**
     * @return Boss
     */
    public function getBoss()
    {
        return $this->creatureFactory->createBoss();
    }

    /**
     * @param Boss $boss
     *
     * @return AttackAction
     *
     * @throws CharacterInsufficientActionException
     */
    public function getBossAttack(Boss $boss)
    {
        return $this->attackStrategyService->getNextAction($boss);
    }

    /**
     * This function calls strategy service to define whether attack was successful or was avoided,
     * based on this it recalculates player statistics.
     * We can substitute strategy service to change current fight mechanic
     *
     * @param Boss           $boss
     * @param Hero           $hero
     * @param AttackAction   $attack
     * @param AbstractAction $defense
     */
    public function attackCalculation(Boss $boss, Hero $hero, AttackAction $attack, AbstractAction $defense)
    {
        $this->attackStrategyService->calculate($boss, $hero, $attack, $defense);
    }

    /**
     * Called at the end of the fight if player have won.
     *
     * @param Profile $profile
     * @param Boss    $boss
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function levelUp(Profile $profile, Boss $boss)
    {
        $oldLevel = $profile->getLevel();
        $profile->setLevel($oldLevel + 1);
        $oldExperience = $profile->getExperience();
        $profile->setExperience($oldExperience + $boss->getExperienceCost());
        $this->manager->persist($profile);
        $this->manager->flush($profile);
    }
}
