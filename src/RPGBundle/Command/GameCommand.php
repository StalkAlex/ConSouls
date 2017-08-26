<?php

namespace RPGBundle\Command;

use RPGBundle\Entity\Action\AbstractAction;
use RPGBundle\Entity\Creature\Boss;
use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Entity\Profile;
use RPGBundle\Service\ActionService;
use RPGBundle\Service\FightService;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GameCommand
 */
class GameCommand extends ContainerAwareCommand
{
    /** @var  ProfileService $profileService */
    private $profileService;
    /** @var FightService $fightService */
    private $fightService;
    /** @var  ActionService $actionService */
    private $actionService;
    /** @var  InputInterface $input */
    private $input;
    /** @var  OutputInterface $output */
    private $output;
    /** @var  SymfonyStyle $io */
    private $io;

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('rpg:game')
            ->setDescription('Starts game');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->profileService = $this->getContainer()->get('rpg.profile');
        $this->fightService = $this->getContainer()->get('rpg.fight');
        $this->actionService = $this->getContainer()->get('rpg.action');
        $this->input = $input;
        $this->output = $output;
        $this->io = new SymfonyStyle($input, $output);
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
        $this->processGame($boss, $hero, $profile);
        $this->showProfileStats($profile);
    }

    /**
     * @return Profile
     */
    private function profileBlock()
    {
        $helper = $this->getHelper('question');
        $this->output->writeln([
            '<comment>',
            'Profile chooser',
            '===============',
            '</comment>',
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

    /**
     * @param Profile $profile
     *
     * @return array
     */
    private function initializeGame(Profile $profile)
    {
        $this->output->writeln([
            '<comment>',
            'Game starting...',
            '================',
            '</comment>',
            '',
        ]);
        $hero = $this->fightService->getHero($profile->getHeroName());
        $boss = $this->fightService->getBoss();
        $this->output->writeln([
            '<info>',
            'You\'re about to fight with '.$boss->getName().' - '.$boss->getDescription(),
            '============================',
            '</info>',
            '',
        ]);

        return [ $boss, $hero ];
    }

    /**
     * @param Boss    $boss
     * @param Hero    $hero
     * @param Profile $profile
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \RPGBundle\Exception\NoActionDefinedException
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    private function processGame(Boss $boss, Hero $hero, Profile $profile)
    {
        $helper = $this->getHelper('question');
        while (true) {
            $attackAction = $this->fightService->getBossAttack($boss);
            $this->output->writeln([
                '<error>',
                'Boss attacking...',
                '=================',
                'Listen carefully and be prepared!',
                'Boss: '.$attackAction->getSound(),
                '</error>',
                '',
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
            $heroBeforeAttack = clone $hero;
            $this->fightService->attackCalculation($boss, $hero, $attackAction, $defenseAction);
            $this->showGameStats($hero, $boss, $heroBeforeAttack);
            //update stats using damage count strategy
            if ($hero->getHealth() <= 0) {
                $this->showFail();
                break;
            }
            if ($boss->getHealth() <= 0) {
                $this->fightService->levelUp($profile, $boss);
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
        $codes = $this->fightService->getHeroActions();

        return array_map(function (AbstractAction $action) {
            return $action->getCode();
        }, $codes);
    }

    /**
     * @param Profile $profile
     */
    private function showProfileStats(Profile $profile)
    {
        $this->output->writeln([
            '<comment>',
            'Profile statistics',
            '=================',
            '',
            'Level: '.$profile->getLevel(),
            'Experience: '.$profile->getExperience(),
            '</comment>',
            '',
        ]);
    }

    /**
     * Shows welcome block of the game
     */
    private function showWelcome()
    {

        $this->output->writeln([
            '<question>',
            'Welcome to hardcore game "ConSouls"',
            '===================================',
            'Fight with bosses and save light of The World or...',
            '...you can destroy it... forever',
            '</question>',
            '',
        ]);
    }

    /**
     * Shows in case of player loses
     */
    private function showFail()
    {
        $this->output->writeln([
            '<error>',
            'You died...',
            '===========',
            '',
            'Please try again.',
            '</error>',
        ]);
    }

    /**
     * Shows in case of player wins
     */
    private function showSuccess()
    {
        $this->output->writeln([
            '<info>',
            'You\'ve won!',
            '============',
            '',
            'Your destiny awaits you.',
            'You can create another profile and play again as in this demo version lives only one boss',
            '</info>',
        ]);
    }

    /**
     * @param Hero $hero
     * @param Boss $boss
     * @param Hero $heroBeforeAttack
     */
    private function showGameStats(Hero $hero, Boss $boss, Hero $heroBeforeAttack)
    {
        if ($heroBeforeAttack->getHealth() !== $hero->getHealth()) {
            $this->output->writeln([
                '<error>',
                'You couldn\'t defend yourself from this attack. Try another action next time.',
                '</error>',
                '',
            ]);
        } else {
            $this->output->writeln([
                '<info>',
                'You\'ve successfully avoided attack and dealt '.$hero->getDamage().' damage!',
                '</info>',
                '',
            ]);
        }
        $this->output->writeln([
            '<comment>',
            'Fight statistics',
            '================',
            'Health Hero/Boss: '.$hero->getHealth().'/'.$boss->getHealth(),
            '</comment>',
            '',
        ]);
    }
}
