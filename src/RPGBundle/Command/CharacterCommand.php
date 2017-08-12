<?php

namespace RPGBundle\Command;

use RPGBundle\Entity\Creature\Hero;
use RPGBundle\Service\CreatureService;
use RPGBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class GameCommand
 */
class CharacterCommand extends ContainerAwareCommand
{

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('rpg_challenge:create_game_user')
            ->setDescription('Create character for a game');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CreatureService $creatureService */
        $creatureService = $this->get('creature');
        /** @var ProfileService $profileService */
        $profileService = $this->get('profile');
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
        $output->writeln('Username: ' . $input->getArgument('username'));
        $output->writeln([
            'CharacterChooser',
            '============',
            '',
        ]);
        $helper = $this->getHelper('question');
        $heroes = $creatureService->GetAvailableHeroes();
        $question = new ChoiceQuestion(
            'Please select your hero)',
            array_map(function(Hero $hero) {
                return $hero->getName();
            }, $heroes),
            0
        );
        $question->setErrorMessage('Choice is invalid');
        $heroName = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: ' . $heroName);

    }
}
