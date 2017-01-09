<?php namespace Three9Dice;

/**
 * Class Constant
 * @package Three9Dice
 */
abstract class Constant
{
	const METHOD_LOGIN                      = 'Login';
	const METHOD_CHANGE_PASSWORD            = 'ChangePassword';
	const METHOD_UPDATE_EMAIL               = 'UpdateEmail';
	const METHOD_UPDATE_EMERGENCY_ADDRESS   = 'UpdateEmergencyAddress';
	const METHOD_WITHDRAW                   = 'Withdraw';
	const METHOD_GET_DEPOSIT_ADDRESS        = 'GetDepositAddress';
	const METHOD_GET_BALANCE                = 'GetBalance';
	const METHOD_GET_SERVER_SEED_HASH       = 'GetServerSeedHash';
	const METHOD_PLACE_BET                  = 'PlaceBet';
	const METHOD_PLACE_AUTOMATED_BET        = 'PlaceAutomatedBets';
	const METHOD_GET_CURRENCIES             = 'GetCurrencies';


	const CURRENCY_BTC  = 'btc';
	const CURRENCY_LTC  = 'ltc';
	const CURRENCY_DOGE = 'doge';
	const CURRENCY_ETH  = 'eth';


	const RANGE_MIN = 0;
	const RANGE_MAX = 999999;
}