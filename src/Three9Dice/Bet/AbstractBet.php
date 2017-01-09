<?php namespace Three9Dice\Bet;

use Three9Dice\Interfaces\BetInterface;
use Three9Dice\Interfaces\GuessRangeInterface;

/**
 * Class AbstractBet
 * @package Three9Dice\Bet
 */
abstract class AbstractBet implements BetInterface
{
	/** @var int $amount */
	private $amount;

	/** @var string $currency */
	private $currency;

	/** @var GuessRangeInterface $guessRange */
	private $guessRange;

	/** @var int $seed */
	private $seed;

	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @return GuessRangeInterface
	 */
	public function getGuessRange()
	{
		return $this->guessRange;
	}

	/**
	 * @param $amount
	 *
	 * @return $this
	 */
	public function setAmount( $amount )
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * @param $currency
	 *
	 * @return $this
	 */
	public function setCurrency( $currency )
	{
		$this->currency = $currency;
		return $this;
	}

	/**
	 * @param GuessRangeInterface $guessRange
	 *
	 * @return $this
	 */
	public function setGuessRange( GuessRangeInterface $guessRange )
	{
		$this->guessRange = $guessRange;
		return $this;
	}

	/**
	 * @param $seed
	 *
	 * @return $this
	 */
	public function setSeed( $seed )
	{
		$this->seed = $seed;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getSeed()
	{
		return $this->seed;
	}

}