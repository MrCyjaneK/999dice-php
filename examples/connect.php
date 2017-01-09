<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$apiKey     = 'Your API key';
$username   = 'Your login';
$password   = 'Your password';
$totp       = 'Your Totp';


$three9DiceClient = new \Three9Dice\Client(
	new \Three9Dice\User($apiKey, $username, $password, $totp)
);
