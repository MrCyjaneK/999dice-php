# Hello, Friends!

It's initial version of [999dice.com](https://www.999dice.com/?79432757) PHP library!


## Examples:

### Create connection:
```php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$apiKey     = '<Your API key>';
$username   = '<Your login>';
$password   = '<Your password>';
$totp       = '<Your Totp>';


$three9DiceClient = new \Three9Dice\Client(
	new \Three9Dice\User($apiKey, $username, $password, $totp)
);

```

### Place BET:

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