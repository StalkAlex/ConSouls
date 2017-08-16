<?php
/**
 * Created by PhpStorm.
 * User: AlexandrAboimov
 * Date: 16.08.2017
 * Time: 14:08
 */

namespace RPGBundle\Service;

use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero\Knight;
use RPGBundle\Entity\Creature\Hero\Mage;
use RPGBundle\Exception\CreatureNotFoundException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class CreatureFactoryServiceTest
 */
class CreatureFactoryServiceTest extends TestCase
{
    /**
     * Test hero creating
     */
    public function testCreateHero()
    {
        $factory = new CreatureFactoryService();
        $knight = $factory->createHero('Knight', [new Roll(), new Shield()]);
        $mage = $factory->createHero('Mage', [new Roll()]);
        $this->assertInstanceOf(Knight::class, $knight);
        $this->assertInstanceOf(Mage::class, $mage);
        $this->assertInstanceOf(Roll::class, $mage->getActions()[0]);
        $this->assertCount(2, $knight->getActions());
        $this->expectException(CreatureNotFoundException::class);
        $factory->createHero('Rogue', []);
    }

    /**
     *  Test boss creating
     */
    public function testCreateBoss()
    {
        $factory = new CreatureFactoryService();
        $boss = $factory->createBoss();
        $this->assertInstanceOf(Boss::class, $boss);
    }
}
