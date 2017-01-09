<?php namespace Three9Dice\GuessRange;

use Three9Dice\Constant;
use Three9Dice\Exception\Three9DiceException;
use Three9Dice\Interfaces\GuessRangeInterface;

/**
 * Class GuessRange
 * @package Three9Dice\GuessRange
 */
class GuessRange extends AbstractGuessRange
{

	const PERCENT_MIN = 5.0;
	const PERCENT_MAX = 95.0;

	/**
	 * @param $low
	 * @param $high
	 * @return GuessRangeInterface
	 */
	public static function generate( $low, $high )
	{
		return new static(ceil($low), floor($high));
	}

	/**
	 * @param $percent
	 * @param bool $lower
	 *
	 * @return GuessRangeInterface
	 * @throws Three9DiceException
	 */
	public static function generatePercent( $percent, $lower = true )
	{
		if( $percent < self::PERCENT_MIN || self::PERCENT_MAX > 95 )
		{
			throw new Three9DiceException(sprintf(
				"Percent must be between %f and %f",
				self::PERCENT_MIN,
				self::PERCENT_MAX
			));
		}

		if( $lower )
		{
			return self::generate(
				Constant::RANGE_MIN,
				Constant::RANGE_MAX * ( $percent / 100 )
			);
		}
		else
		{
			return self::generate(
				Constant::RANGE_MAX * ((100 - $percent) / 100),
				Constant::RANGE_MAX
			);
		}
	}

	/**
	 * @param $percent
	 *
	 * @return GuessRangeInterface
	 */
	public static function generateRandom( $percent )
	{
		$prc = ($percent / 100);
		$low = mt_rand( Constant::RANGE_MIN, ceil( Constant::RANGE_MAX * (1-$prc)) );
		$high = $low + Constant::RANGE_MAX * $prc;
		return self::generate( $low, $high );
	}


}