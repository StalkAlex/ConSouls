<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 15.08.2017
 * Time: 19:58
 */

namespace RPGBundle\Command;

use RPGBundle\Entity\Profile;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CharacterCommandTest
 */
class CharacterCommandTest extends WebTestCase
{
    /** @var  Command $command */
    private $command;
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $serviceMock;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $application = new Application(static::$kernel);
        $application->add(new CharacterCommand());
        $command = $application->find('rpg:create_profile');
        $command->setApplication($application);
        $this->command = $command;

        //mock to not perform actual saving
        $serviceMock = $this->getMockBuilder(ProfileService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $serviceMock->expects($this->once())
            ->method('createProfile')
            ->willReturn(true);
        $this->serviceMock = $serviceMock;
    }

    public function testCreateProfile()
    {
        static::$kernel->getContainer()->set('rpg.profile', $this->serviceMock);
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['Tester', 'Knight']);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        $this->assertContains('successfully created', $output);
    }

    public function testCreateAnonymousProfile()
    {
        static::$kernel->getContainer()->set('rpg.profile', $this->serviceMock);
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['', 'Knight']);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        $this->assertContains('successfully created', $output);
        $this->assertContains('anonymous', $output);
    }

    public function testIfValidationShowsForDuplicateName()
    {
        //simulate existence of Tester profile
        $this->serviceMock->expects($this->any())
            ->method('getProfile')
            ->willReturnCallback(function ($name) {
                if ($name === 'Tester') {
                    return new Profile();
                }
                return null;
            });
        static::$kernel->getContainer()->set('rpg.profile', $this->serviceMock);
        //then try to register with Tester profile, it should show us validation error and ask for another value
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['Tester', 'NewTester', 'Knight']);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        $this->assertContains('Please try another', $output);
        $this->assertContains('successfully created', $output);
    }
}