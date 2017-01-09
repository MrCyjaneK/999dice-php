<?php namespace Three9Dice\Bet;

use Three9Dice\Constant;
use Three9Dice\Exception\Three9DiceException;
use Three9Dice\GuessRange\GuessRange;
use Three9Dice\Interfaces\GuessRangeInterface;

/**
 * Class Bet
 * @package Three9Dice
 */
class Bet extends AbstractBet
{
	/**
	 * Bet constructor.
	 *
	 * @param int $amount - in satoshi
	 * @param string $currency
	 * @param GuessRangeInterface|null $guessRange
	 * @throws Three9DiceException
	 */
	public function __construct( $amount = 10, $currency = Constant::CURRENCY_BTC, $guessRange = 49.95 )
	{
		$this->setAmount($amount);

		$this->setCurrency($currency);

		$this->setSeed(1);

		if( is_numeric($guessRange) )
		{
			$this->setGuessRange( GuessRange::generatePercent($guessRange) );
		}
		elseif( $guessRange instanceof GuessRangeInterface )
		{
			$this->setGuessRange($guessRange);
		}
		else
		{
			throw new Three9DiceException(
				"Invalid guessRange. Must be percent (5, 95) or implement of GuessRangeInterface"
			);
		}
	}

	/**
	 * @return array
	 */
	public function getRequestParams()
	{
		return [
			'PayIn'     => $this->getAmount(),
			'Currency'  => $this->getCurrency(),

			'Low'   => $this->getGuessRange()->getLow(),
			'High'  => $this->getGuessRange()->getHigh(),

			'ClientSeed'        => $this->getSeed(),
		    'ProtocolVersion'   => 2
		];
	}
}