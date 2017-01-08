<?php namespace Three9Dice\Exception;

use Exception;

/**
 * Class RequestException
 * @package Three9Dice\Exception
 */
class RequestException extends Three9DiceException
{
	/**
	 * RequestException constructor.
	 *
	 * @param string $message
	 */
	public function __construct($message = "")
	{
		parent::__construct($message);
	}
}