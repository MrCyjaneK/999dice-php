<?php

namespace Three9Dice\Bots;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Three9Dice\Bots\Service\Configurate\DefaultConfigParser;
use Three9Dice\Exception\Three9DiceException;
use Three9Dice\Helper;
use Three9Dice\User;

/**
 * Class DefaultBotCommand
 * @package Three9Dice\Bots
 */
class DefaultBotCommand extends Command
{
    /** @var DefaultConfigParser $config */
    protected $config;

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('run:default')
            ->addArgument('config', InputArgument::REQUIRED, 'The config path')
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
        $configFile = $input->getArgument('config');
        $configFilePath = realpath($configFile);

        if (!$configFilePath) {
            $output->writeln("<error>Config file not found by: {$configFile}</error> ");
        }

        $output->writeln("<info>Config path</info>: {$configFilePath}");

        $this->config = new DefaultConfigParser($configFilePath);

        $this->startBot($output);
    }

    /**
     * @param OutputInterface $output
     */
    private function startBot(OutputInterface $output)
    {
        $output->writeln('<info>Bot started!</info>');

        $martingaleBot = new Morok714(
            new User(
                $this->config->getApiKey(),
                $this->config->getUsername(),
                $this->config->getPassword()
            ),
            $this->config->get('strategy.amountCoef'),
            $this->config->get('strategy.currency')
        );


        try {
            $martingaleBot->start($this->getHandler($output));
        } catch(Three9DiceException $e) {
            echo $e->getMessage() . "\n";
            die;
        }
    }


    /**
     * @param OutputInterface $output
     *
     * @return \Closure
     */
    private function getHandler(OutputInterface $output)
    {
        $betPerSec = 0;
        $currencyRate = $this->config->get('currencyRate', 0);
        $stopPercent = $this->config->get('stopPercent', 0.01);

        return function (Morok714 $bot, $result) use ($currencyRate, &$betPerSec, $stopPercent) {
            $profit = Helper::satoshi2Btc($bot->getProfit()) * $currencyRate;

            if(0 == ($bot->getBetCount() % 5)) {
                $now = time();
                $timeDelay = ($now - $bot->getStartWorkTime()->getTimestamp());
                $betPerSec = $timeDelay ? $bot->getBetCount() / $timeDelay : 0;
            }

            system('clear');

            $str = sprintf(
                "\n\n" .
                " Profit:     [%15s] [%8s] - [%12s]\n\n" .
                " Bet count:  [%6d] (Max depth: %d)\n" .
                " Total Bets: [W:%6d|L:%6d] (%s bet/s)\n\n" .
                " Start BET:  [%11s]\n" .
                "====================================================\n",
                number_format(Helper::satoshi2Btc($bot->getProfit()), 8),
                number_format($bot->getProfit() / $bot->getStartBalance() * 100, 2) . '%',
                number_format($profit, 2),
                $bot->getCurrentDepth(),
                $bot->getMaxDepth(),
                $bot->getWinCount(),
                $bot->getBetCount() - $bot->getWinCount(),
                number_format($betPerSec, 1),
                number_format($bot->getStartAmount(), 0)
            );

            $str .= sprintf(
                "\n Max Drawdown: [%17s] [%6s]",
                number_format(Helper::satoshi2Btc($bot->getMaxDrawdown()), 8),
                -number_format($bot->getMaxDrawdown() / $bot->getStartBalance() * 100, 2) . "%"
            );
            $str .= sprintf("\n Max BET:      [%17s]", number_format(Helper::satoshi2Btc($bot->getMaxBet()), 8));
            $str .= sprintf("\n Max BALANCE:  [%17s]", number_format(Helper::satoshi2Btc($bot->getMaxBalance()), 8));
            $str .= "\n";

            //	replaceOut($str);
            echo $str;

            if($stopPercent && $bot->getProfit() > $bot->getStartBalance() * $stopPercent) {
                $bot->stop();
                echo "\n\n - Done bot work with a profit: " . number_format(Helper::satoshi2Btc($bot->getProfit()), 8) . "\n\n";
            }
        };
    }

}