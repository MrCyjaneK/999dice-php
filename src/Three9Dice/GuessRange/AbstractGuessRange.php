<?php namespace Three9Dice\GuessRange;

use Three9Dice\Interfaces\GuessRangeInterface;

/**
 * Class AbstractGuessRange
 * @package Three9Dice\GuessRange
 */
abstract class AbstractGuessRange implements GuessRangeInterface
{
	private $high;
	private $low;

	/**
	 * AbstractGuessRange constructor.
	 *
	 * @param $low
	 * @param $high
	 */
	public function __construct( $low, $high )
	{
		$this->setLow($low);
		$this->setHigh($high);
	}

	/**
	 * @param $low
	 *
	 * @return $this
	 */
	public function setLow( $low )
	{
		$this->low = $low;
		return $this;
	}

	/**
	 * @param $high
	 *
	 * @return $this
	 */
	public function setHigh( $high)
	{
		$this->high = $high;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getHigh()
	{
		return $this->high;
	}

	/**
	 * @return int
	 */
	public function getLow()
	{
		return $this->low;
	}

}