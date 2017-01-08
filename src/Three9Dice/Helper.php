<?php namespace Three9Dice;

/**
 * Class Helper
 * @package Three9Dice
 */
class Helper
{
	const SATOSHI_IN_BTC = 100000000;

	/**
	 * @param $btc
	 * @return int
	 */
	public static function btc2Satoshi($btc)
	{
		return ceil( $btc * self::SATOSHI_IN_BTC );
	}

	/**
	 * @param $satoshi
	 * @return float|int
	 */
	public static function satoshi2Btc($satoshi)
	{
		return $satoshi / self::SATOSHI_IN_BTC;
	}

}