# Hello, Friends!

It's initial version of [999dice.com](https://www.999dice.com/?79432757) PHP library!


## Examples:

### Connect:
```php

<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$apiKey     = '<Your API key>';
$username   = '<Your login>';
$password   = '<Your password>';
$totp       = '<Your Totp>';


$three9DiceClient = new \Three9Dice\Client(
	new \Three9Dice\User($apiKey, $username, $password, $totp)
);

```