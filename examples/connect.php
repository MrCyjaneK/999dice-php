<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use Three9Dice\Client;
use Three9Dice\User;
use Three9Dice\Bet\Bet;


$apiKey     = 'Your API key';
$username   = 'Your login';
$password   = 'Your password';
$totp       = 'Your Totp';


$startTime = microtime(true);
$three9DiceClient = new Client(
	new User($apiKey, $username, $password)
);
echo "\n\n " . (microtime(true) - $startTime) . "\n\n";


$baseBetAmount = 1;
$bet = new Bet(
	$baseBetAmount,
	\Three9Dice\Constant::CURRENCY_ETH,
	\Three9Dice\GuessRange\GuessRange::generateRandom(49.95)
);

while( true )
{
	$result = $three9DiceClient->placeBet($bet);

	echo sprintf( "%s | %s \n", $result['BetId'], $result['PayOut'] );

	if( $result['PayOut'] == 0 )
	{
		$bet->setAmount( $bet->getAmount() * 2 );
	}
	else
	{
		$bet->setAmount($baseBetAmount);
	}
	usleep(10);
}

