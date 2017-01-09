<?php namespace Three9Dice\Interfaces;

/**
 * Interface GuessRangeInterface
 * @package Three9Dice\Interfaces
 */
interface GuessRangeInterface
{
	/**
	 * @return int
	 */
	public function getLow();

	/**
	 * @return int
	 */
	public function getHigh();
}