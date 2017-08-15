<?php

namespace RPGBundle\Command;

use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Service\GameService;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class GameCommand
 */
class CharacterCommand extends ContainerAwareCommand
{
    /** @var GameService $creatureService */
    private $gameService;
    /** @var ProfileService $profileService */
    private $profileService;

    /**
     * @return void
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('rpg:create_profile')
            ->setDescription('Create your profile choosing name and character class');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \LogicException
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->gameService = $this->getContainer()->get('rpg.game');
        $this->profileService = $this->getContainer()->get('rpg.profile');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
        $helper = $this->getHelper('question');
        $question = new Question(
            "Please enter profile name or random generated will be used: \n",
            'anonym'.uniqid()
        );
        $name = $helper->ask($input, $output, $question);
        $output->writeln('Username: '.$name);

        $output->writeln([
            'Character Chooser',
            '=================',
            '',
        ]);
        $choice = new ChoiceQuestion(
            'Please select your hero:',
            $this->getHeroList(),
            0
        );
        $choice->setErrorMessage('Choice is invalid');
        $heroName = $helper->ask($input, $output, $choice);
        $output->writeln('You have just selected: '.$heroName);

        $this->profileService->createProfile($name, $heroName);
        $output->writeln('Your profile successfully created!');
    }

    /**
     * @return array
     */
    private function getHeroList()
    {
        $heroes = $this->gameService->getAvailableHeroes();

        return array_map(function (Hero $hero) {
            return $hero->getName();
        }, $heroes);
    }
}
