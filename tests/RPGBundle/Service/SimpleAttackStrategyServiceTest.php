<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 16.08.2017
 * Time: 15:54
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action\Grasp;
use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Boss\FireChampion;
use RPGBundle\Entity\Creature\Hero\Knight;
use RPGBundle\Exception\CharacterInsufficientActionException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class SimpleAttackStrategyServiceTest
 */
class SimpleAttackStrategyServiceTest extends TestCase
{
    /**
     * Test getNextAction
     */
    public function testGetNextAction()
    {
        $simpleAttackStrategyService = new SimpleAttackStrategyService();
        $action = new Grasp();
        $boss = new FireChampion([$action]);
        $this->assertSame($action->getCode(), $simpleAttackStrategyService->getNextAction($boss)->getCode());
        $this->expectException(CharacterInsufficientActionException::class);
        $simpleAttackStrategyService->getNextAction(new Boss([]));
    }

    /**
     * Test fight calculation logic
     */
    public function testCalculate()
    {
        $simpleAttackStrategyService = new SimpleAttackStrategyService();
        $boss = new FireChampion([]);
        $hero = new Knight([]);
        $attack = new Grasp();
        $failedDefenseAction = new Shield();
        $successDefenseAction = new Roll();
        $heroHealth = $hero->getHealth();
        $bossHealth = $boss->getHealth();
        //test failed defense
        $simpleAttackStrategyService->calculate($boss, $hero, $attack, $failedDefenseAction);
        //boss health should not be changed
        $this->assertEquals($bossHealth, $boss->getHealth());
        //hero health should be decreased by value of boss damage
        $expectedHeroHealth = $heroHealth - $boss->getDamage();
        $this->assertEquals($expectedHeroHealth, $hero->getHealth());
        //test success defense
        $simpleAttackStrategyService->calculate($boss, $hero, $attack, $successDefenseAction);
        //hero health should be the same as before attack
        $this->assertEquals($expectedHeroHealth, $hero->getHealth());
        //boss health should be decreased by value of hero damage
        $expectedBossHealth = $bossHealth - $hero->getDamage();
        $this->assertEquals($expectedBossHealth, $boss->getHealth());
    }
}
