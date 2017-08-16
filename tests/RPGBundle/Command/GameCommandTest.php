<?php
namespace RPGBundle\Command;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Action\FireStorm;
use RPGBundle\Entity\Action\Grasp;
use RPGBundle\Entity\Action\Roll;
use RPGBundle\Entity\Action\Shield;
use RPGBundle\Entity\Creature\Boss\FireChampion;
use RPGBundle\Entity\Creature\Hero\Knight;
use RPGBundle\Entity\Profile;
use RPGBundle\Service\CreatureFactoryService;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class GameCommandTest
 */
class GameCommandTest extends WebTestCase
{
    /** @var  Command $command */
    private $command;
    /** @var  \PHPUnit_Framework_MockObject_MockObject $emMock */
    private $emMock;
    /** @var  \PHPUnit_Framework_MockObject_MockObject $creatureFactoryServiceMock */
    private $creatureFactoryServiceMock;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $application = new Application(static::$kernel);
        $application->add(new GameCommand());
        $command = $application->find('rpg:game');
        $command->setApplication($application);
        $this->command = $command;

        //mocking one profile to play the game
        $profile = new Profile();
        $profile->setName('Tester');
        $profile->setHeroName('Knight');
        $profileServiceMock = $this->getMockBuilder(ProfileService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profileServiceMock->expects($this->once())
            ->method('getProfiles')
            ->willReturn([$profile]);
        $profileServiceMock->expects($this->once())
            ->method('getProfile')
            ->willReturn($profile);
        static::$kernel->getContainer()->set('rpg.profile', $profileServiceMock);
        //mocking entity manager
        $emMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        static::$kernel->getContainer()->set('doctrine.orm.default_entity_manager', $emMock);
        $this->emMock = $emMock;
        //mocking creature factory
        $creatureFactoryServiceMock = $this->getMockBuilder(CreatureFactoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $creatureFactoryServiceMock->expects($this->once())
            ->method('createHero')
            ->willReturn(new Knight([new Roll(), new Shield()]));
        static::$kernel->getContainer()->set('rpg.creature_factory', $creatureFactoryServiceMock);
        $this->creatureFactoryServiceMock = $creatureFactoryServiceMock;
    }

    /**
     * Test win scenario
     */
    public function testIfGameCouldBeWon()
    {
        //mocking boss with only one action, that can be rolled
        $this->creatureFactoryServiceMock->expects($this->once())
            ->method('createBoss')
            ->willReturn(new FireChampion([new Grasp()]));
        //mock manager actual saving methods to db
        //it should be called at least once as we win and game should update profile statistics
        $this->emMock->expects($this->once())
            ->method('persist')
            ->willReturn(true);
        $this->emMock->expects($this->once())
            ->method('flush')
            ->willReturn(true);
        $commandTester = new CommandTester($this->command);
        //choose to roll everytime - this is win strategy :)
        $commandTester->setInputs([0, 0, 0, 0, 0, 0]);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        $this->assertContains('You\'ve won!', $output);
    }

    /**
     * Test lose scenario
     */
    public function testIfGameCouldBeLost()
    {
        //same as in win test, but will mock unrollable action
        $this->creatureFactoryServiceMock->expects($this->once())
            ->method('createBoss')
            ->willReturn(new FireChampion([new FireStorm()]));
        //mock db actions, it should never be called as we're going to lose and statistics won't update
        $this->emMock->expects($this->never())
            ->method('persist')
            ->willReturn(true);
        $this->emMock->expects($this->never())
            ->method('flush')
            ->willReturn(true);
        $commandTester = new CommandTester($this->command);
        //again choose to roll everytime as action is unrollable game will be loosed
        $commandTester->setInputs([0, 0, 0, 0, 0, 0]);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        $this->assertContains('You died...', $output);
    }
}
