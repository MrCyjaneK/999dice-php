<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use \Three9Dice\Bots\Morok714;
use \Three9Dice\Helper;

$config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);

$apiKey = $config['apiKey'];
$username = $config['username'];
$password = $config['password'];

function replaceOut($str)
{
    $numNewLines = substr_count($str, "\n");
    echo chr(27) . "[0G";
    echo $str;
    echo chr(27) . "[" . $numNewLines . "A"; // Set cursor up x lines
}

$strategy = $config['strategy'];
$martingaleBot = new Morok714(
    new \Three9Dice\User($apiKey, $username, $password),
    $strategy['amount'],
    $strategy['currency'],
    isset($strategy['depth_orient']) ? $strategy['depth_orient'] : false
);

$stopPercent = isset($strategy['stop_percent']) ? $strategy['stop_percent'] : false;
$currencyRate = 1235;

echo "\n";

$betPerSec = 0;
/**
 * @param Morok714 $bot
 * @param $result
 */
$betHandler = function (Morok714 $bot, $result) use ($currencyRate, &$betPerSec, $stopPercent)
{
    $profit = \Three9Dice\Helper::satoshi2Btc($bot->getProfit()) * $currencyRate;

    if(0 == ($bot->getBetCount() % 5))
    {
        $now = time();
        $timeDelay = ($now - $bot->getStartWorkTime()->getTimestamp());
        $betPerSec = $timeDelay ? $bot->getBetCount() / $timeDelay : 0;
    }

    system('clear');

    $str = sprintf(
        "\n\n" .
        " Profit:     [%15s] [%8s] - [%12s]\n\n" .
        " Bet count:  [%6d] (Max depth: %d)\n" .
        " Total Bets: [%6d] (%s bet/s)\n\n" .
        " Start BET:  [%11s]\n" .
        "====================================================\n",
        number_format(Helper::satoshi2Btc($bot->getProfit()), 8),
        number_format($bot->getProfit() / $bot->getStartBalance() * 100, 2) . '%',
        number_format($profit, 2),
        $bot->getCurrentDepth(),
        $bot->getMaxDepth(),
        $bot->getBetCount(),
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

	if($stopPercent && $bot->getProfit() > $bot->getStartBalance() * $stopPercent)
	{
		$bot->stop();
		echo "\n\n - Done bot work with a profit: " . number_format(Helper::satoshi2Btc($bot->getProfit()), 8) . "\n\n";
	}
};

try
{
    $martingaleBot->start($betHandler);
}
catch(\Three9Dice\Exception\Three9DiceException $e)
{
    echo $e->getMessage() . "\n";
    die;
}
