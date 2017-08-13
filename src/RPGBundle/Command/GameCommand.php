<?php

namespace RPGBundle\Command;

use RPGBundle\Entity\Profile;
use RPGBundle\Service\CreatureService;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class GameCommand
 */
class GameCommand extends ContainerAwareCommand
{
    /** @var  CreatureService $creatureService */
    private $creatureService;
    /** @var  ProfileService $profileService */
    private $profileService;

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('rpg:game')
            ->setDescription('Starts game');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->creatureService = $this->getContainer()->get('rpg.creature');
        $this->profileService = $this->getContainer()->get('rpg.profile');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $output->writeln([
            'Profile chooser',
            '===============',
            '',
        ]);
        $choice = new ChoiceQuestion(
            'Please choose your profile. To create new profile use rpg:create_profile',
            $this->getProfilesList(),
            0
        );
        $choice->setErrorMessage('Choice is invalid');
        $profileName = $helper->ask($input, $output, $choice);
        $profile = $this->profileService->getProfile($profileName);
        $this->showProfileStats($profile, $output);
        $output->writeln([
            'Game starting...',
            '================',
            '',
        ]);
        $hero = $this->creatureService->getHero($profile->getHeroName());
        $boss = $this->creatureService->getBoss();
        $output->writeln([
            'You\'re about to fight with ' . $boss->getName() . '-' . $boss->getDescription(),
            '================',
            '',
        ]);
        while(true) {
            
        }
    }

    private function getProfilesList()
    {
        $names = $this->profileService->getProfiles();
        return array_map(function (Profile $hero) {
            return $hero->getName();
        }, $names);
    }

    private function showProfileStats(Profile $profile, OutputInterface $output)
    {
        $output->writeln([
            'Profile statistic',
            '=================',
            '',
            'Level: ' . $profile->getLevel(),
            'Experience: ' . $profile->getExperience(),
        ]);
    }
}
