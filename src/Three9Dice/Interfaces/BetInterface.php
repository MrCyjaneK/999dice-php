<?php namespace Three9Dice\Interfaces;

/**
 * Interface BetInterface
 * @package Three9Dice\Interfaces
 */
interface BetInterface
{
	/**
	 * @return int
	 */
	public function getAmount();

	/**
	 * @return string
	 */
	public function getCurrency();

	/**
	 * @return GuessRangeInterface
	 */
	public function getGuessRange();

	/**
	 * @return int
	 */
	public function getSeed();

	/**
	 * @return array
	 */
	public function getRequestParams();

}