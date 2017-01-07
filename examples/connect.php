<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use Three9Dice\Client;


$apiKey = 'apikey';
$username = 'your username';
$password = 'your password';

$three9Dice = new Client($apiKey, $username, $password);

print_r($three9Dice);
