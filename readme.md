# Hello, Friends!

It's initial version of [999dice.com](https://www.999dice.com/?79432757) PHP library!

[999dice PHP library on Packages.org](https://packagist.org/packages/reilag/999dice)

## Install
You can add 999dice as a dependency using the composer.phar CLI:

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add dependency
php composer.phar require reilag/999dice
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Examples:

*Create connection:*
```php
$apiKey     = '***** Your API key *****';
$username   = '***** Your login *****';
$password   = '***** Your password *****';
$totp       = '***** Your Totp *****';

$three9DiceClient = new \Three9Dice\Client(
	new \Three9Dice\User($apiKey, $username, $password, $totp)
);
```

*Place BET:*
```php
/* Generate bet bet before placing */
$bet = new \Three9Dice\Bet\Bet(
	// Amount in satoshi
	10000,
	// Currency ( default )
	\Three9Dice\Constant::CURRENCY_BTC, 
	// GuessRange 
	\Three9Dice\GuessRange\GuessRange::generatePercent(49.95, true)
);

$three9DiceClient->placeBet( $bet );
```