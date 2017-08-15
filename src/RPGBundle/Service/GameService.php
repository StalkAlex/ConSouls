<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 12.08.2017
 * Time: 15:21
 */

namespace RPGBundle\Service;


use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Action;
use RPGBundle\Entity\AttackAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Entity\Profile;
use RPGBundle\Exception\NoActionDefinedException;
use RPGBundle\Service\Domain\IAttackStrategy;
use RPGBundle\Service\Domain\ICreatureFactory;

class GameService
{
    /** @var  IAttackStrategy */
    private $attackStrategyService;
    /** @var CreatureFactoryService $creatureFactory */
    private $creatureFactory;
    /** @var  ActionService $actionService */
    private $actionService;
    /** @var  EntityManager $manager */
    private $manager;

    public function __construct(
        IAttackStrategy $attackStrategyService,
        ICreatureFactory $creatureFactory,
        ActionService $actionService,
        EntityManager $manager)
    {
        $this->attackStrategyService = $attackStrategyService;
        $this->creatureFactory = $creatureFactory;
        $this->actionService = $actionService;
        $this->manager = $manager;
    }

    /**
     * Returns all available heroes in the game.
     * For a simplicity it will return hardcoded instance, later it could be configured outside
     * @return array
     */
    public function getAvailableHeroes()
    {
        return [
            $this->getHero('Knight'),
            $this->getHero('Mage')
        ];
    }

    /**
     * @return array
     */
    public function getHeroActions()
    {
        return $this->actionService->getAvailableDefenseActions();
    }

    /**
     * @param string $name
     * @return Hero
     */
    public function getHero(string $name)
    {
        return $this->creatureFactory->createHero($name, $this->actionService->getAvailableDefenseActions());
    }

    /**
     * @param string $code
     * @return Action
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

    public function attackCalculation(Boss $boss, Hero $hero, AttackAction $attack, Action $defense)
    {
        $this->attackStrategyService->calculate($boss, $hero, $attack, $defense);
    }

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