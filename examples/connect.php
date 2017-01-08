<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use Three9Dice\Client;
use Three9Dice\User;

$apiKey = 'You api key';
$username = 'your login';
$password = 'your password';
$totp = 'your totp';

$startTime = microtime(true);
$three9DiceClient = new Client(
	new User($apiKey, $username, $password, $totp)
);
echo "\n\n " . (microtime(true) - $startTime);
