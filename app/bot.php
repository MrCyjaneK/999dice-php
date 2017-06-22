<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;

use \Three9Dice\Bots\DefaultBotCommand;

$application = new Application();
$application->add(new DefaultBotCommand());

return $application;

