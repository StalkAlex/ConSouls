<?php

namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Creature\Boss\FireChampion;
use RPGBundle\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class GameServiceTest
 */
class GameServiceTest extends TestCase
{
    /**
     * Test levelUp is working properly
     */
    public function testLevelUp()
    {
        $emMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $emMock->expects($this->once())
            ->method('persist')
            ->willReturn(true);
        $emMock->expects($this->once())
            ->method('flush')
            ->willReturn(true);
        $gameService = new GameService(
            new SimpleAttackStrategyService(),
            new CreatureFactoryService(),
            new ActionService(new ActionFactoryService()),
            $emMock
        );
        $profile = new Profile();
        $boss = new FireChampion([]);
        $gameService->levelUp($profile, $boss);
        $this->assertEquals(2, $profile->getLevel());
        $this->assertEquals($boss->getExperienceCost(), $profile->getExperience());
    }
}
