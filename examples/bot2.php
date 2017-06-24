<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use \Three9Dice\Bots\MartingaleBot;

$config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);

$apiKey = $config['apiKey'];
$username = $config['username'];
$password = $config['password'];

$strategy = $config['strategy'];
$martingaleBot = new MartingaleBot(
    new \Three9Dice\User($apiKey, $username, $password),
    $strategy['amount'],
    $strategy['currency'],
    isset($strategy['depth_orient']) ? $strategy['depth_orient'] : false
);

$currencyRate = 0.0031;

echo "\n";

$betPerSec = 0;
/**
 * @param MartingaleBot $bot
 * @param $result
 */
$betHandler = function (MartingaleBot $bot, $result) use ($currencyRate, &$betPerSec) {
    $profit = \Three9Dice\Helper::satoshi2Btc($bot->getProfit()) * $currencyRate;

    if(0 == ($bot->getBetCount() % 50)) {
        $now = time();
        $timeDelay = ($now - $bot->getStartWorkTime()->getTimestamp());
        $betPerSec = $timeDelay ? $bot->getBetCount() / $timeDelay : 0;
    }

    echo sprintf(
        "\r [%15s] - [%9s] | %d (%d) | Bets: %d (%s bet/s) - [%10s]",
        number_format($bot->getProfit()),
        number_format($profit, 4),
        $bot->getCurrentDepth(),
        $bot->getMaxDepth(),
        $bot->getBetCount(),
        number_format($betPerSec, 1),
        number_format($bot->getStartAmount(), 0, ".", " ")
    );
};

try {
    $martingaleBot->start($betHandler);
} catch(\Three9Dice\Exception\Three9DiceException $e) {
    echo $e->getMessage();
    die;
}
