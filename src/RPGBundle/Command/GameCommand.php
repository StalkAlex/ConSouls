<?php

namespace RPGBundle\Command;

use RPGBundle\Action;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Entity\Profile;
use RPGBundle\Service\ActionService;
use RPGBundle\Service\CreatureService;
use RPGBundle\Service\GameService;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class GameCommand
 */
class GameCommand extends ContainerAwareCommand
{
    /** @var  ProfileService $profileService */
    private $profileService;
    /** @var GameService $gameService */
    private $gameService;
    /** @var  ActionService $actionService */
    private $actionService;
    /** @var  InputInterface $input */
    private $input;
    /** @var  OutputInterface $output */
    private $output;

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
        $this->profileService = $this->getContainer()->get('rpg.profile');
        $this->gameService = $this->getContainer()->get('rpg.game');
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->showWelcome();
        $profile = $this->profileBlock();
        $this->showProfileStats($profile);
        list($boss, $hero) = $this->initializeGame($profile);
        $this->processGame($boss, $hero);
    }

    private function profileBlock()
    {
        $helper = $this->getHelper('question');
        $this->output->writeln([
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
        $profileName = $helper->ask($this->input, $this->output, $choice);
        return $this->profileService->getProfile($profileName);
    }

    private function initializeGame(Profile $profile)
    {
        $this->output->writeln([
            'Game starting...',
            '================',
            '',
        ]);
        $hero = $this->gameService->getHero($profile->getHeroName());
        $boss = $this->gameService->getBoss();
        $this->output->writeln([
            'You\'re about to fight with ' . $boss->getName() . '-' . $boss->getDescription(),
            '============================',
            '',
        ]);
        return [ $boss, $hero ];
    }

    private function processGame(Boss $boss, Hero $hero, Profile $profile)
    {
        $helper = $this->getHelper('question');
        while (true) {
            $attackAction = $this->gameService->getBossAttack($boss);
            $this->output->writeln([
                'Boss attacking...',
                '=================',
                'Listen carefully and be prepared!',
                'Boss: ' . $attackAction->getSound(),
                ''
            ]);
            //ask def action
            $choice = new ChoiceQuestion(
                'What will you do, valiant warrior?',
                $this->getHeroActions(),
                0
            );
            $choice->setErrorMessage('Choice is invalid');
            $actionCode = $helper->ask($this->input, $this->output, $choice);
            $defenseAction = $this->actionService->getAction($actionCode);
            $this->gameService->attackCalculation($boss, $hero, $attackAction, $defenseAction);
            $this->showGameStats();
            //update stats using damage count strategy
            if ($hero->getHealth() <= 0) {
                $this->showFail();
                break;
            }
            if ($boss->getHealth() <= 0) {
                $this->showSuccess();
                break;
            }
        }
    }

    /**
     * @return array
     */
    private function getProfilesList()
    {
        $names = $this->profileService->getProfiles();
        return array_map(function (Profile $hero) {
            return $hero->getName();
        }, $names);
    }

    /**
     * @return array
     */
    private function getHeroActions()
    {
        $codes = $this->gameService->getHeroActions();
        return array_map(function (Action $action) {
            return $action->getCode();
        }, $codes);
    }

    /**
     * @param Profile $profile
     */
    private function showProfileStats(Profile $profile)
    {
        $this->output->writeln([
            'Profile statistics',
            '=================',
            '',
            'Level: ' . $profile->getLevel(),
            'Experience: ' . $profile->getExperience(),
        ]);
    }

    private function showWelcome()
    {
        $this->output->writeln([
            'Welcome to hardcore game "ConSouls"',
            '===================================',
            'Fight with bosses and save light of The World or...',
            '...you can destroy it... forever',
        ]);
    }

    private function showFail()
    {
        $this->output->writeln([
            'You died...',
            '===========',
            '',
            'Please try again.'
        ]);
    }

    private function showSuccess()
    {
        $this->output->writeln([
            'You\'ve won!',
            '============',
            '',
            'Your destiny awaits you.',
            'You can create another profile and play again as in this demo version lives only one boss',
        ]);
    }

}
