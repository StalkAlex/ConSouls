<?php
/**
 * Created by PhpStorm.
 * User: stalk
 * Date: 15.08.2017
 * Time: 19:58
 */

namespace RPGBundle\Command;

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
    }

    public function testCreateProfile()
    {
        $output = $this->createTesterUser();
        $this->assertContains('successfully created', $output);
    }

    public function testCreateAnonymousProfile()
    {
        $output = $this->createAnonymousUser();
        $this->assertContains('successfully created', $output);
        $this->assertContains('anonymous', $output);
    }

    public function testIfValidationShowsForDuplicateName()
    {
        //create one user
        $this->createTesterUser();
        //then firstly try to create user with registered name
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['Tester', 'NewTester', 'Knight']);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        $output = $commandTester->getDisplay();
        $this->assertContains('Please try another', $output);
        $this->assertContains('successfully created', $output);
    }

    public function tearDown()
    {
        //cleaning up
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->createQuery('DELETE FROM RPGBundle:profile')->execute();
        parent::tearDown();
    }

    private function createTesterUser()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['Tester', 'Knight']);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        return $commandTester->getDisplay();
    }

    private function createAnonymousUser()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->setInputs(['', 'Knight']);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
        return $commandTester->getDisplay();
    }
}