<?php

namespace Three9Dice\Bots;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DefaultBotCommand
 * @package Three9Dice\Bots
 */
class DefaultBotCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('run:default')
            ->setDescription('Start a default bot');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Bot started!</info>');
    }
}