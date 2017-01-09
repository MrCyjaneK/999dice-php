<?php namespace Three9Dice\Bots;

use Three9Dice\Client;
use Three9Dice\Constant;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class AbstractBot
 * @package Three9Dice\Bots
 */
abstract class AbstractBot
{
	/** @var Client $client */
	private $client;

	/** @var int $balance */
	private $startBalance;

	/** @var int $profit */
	private $profit = 0;

	/** @var int $betsCount */
	private $betsCount = 0;

	/**
	 * @var \DateTime $startWorkTime
	 */
	private $startWorkTime;

	/**
	 * MartingaleBot constructor.
	 *
	 * @param UserInterface $user
	 */
	public function __construct( UserInterface $user )
	{
		$this->setClient( new Client($user) );
	}

	/**
	 * @return Client
	 */
	public function getClient()
	{
		return $this->client;
	}

	/**
	 * @return \DateTime
	 */
	protected function initStartWorkTime()
	{
		$this->startWorkTime = new \DateTime();
		return $this->startWorkTime;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartWorkTime()
	{
		return $this->startWorkTime;
	}

	/**
	 * @param Client $client
	 *
	 * @return $this
	 */
	public function setClient( Client $client )
	{
		$this->client = $client;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getBalance()
	{
		return $this->getStartBalance() + $this->getProfit();
	}

	/**
	 * @param $balance
	 *
	 * @return $this
	 */
	protected function setStartBalance( $balance )
	{
		$this->startBalance = $balance;
		return $this;
	}

	/**
	 * @param $amount
	 *
	 * @return $this
	 */
	public function changeProfit( $amount )
	{
		$this->profit += $amount;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getStartBalance()
	{
		return $this->startBalance;
	}

	/**
	 * @return int
	 */
	public function getProfit()
	{
		return $this->profit;
	}

	/**
	 *
	 */
	protected function iterateBetCount()
	{
		$this->betsCount++;
	}

	/**
	 * @return int
	 */
	public function getBetCount()
	{
		return $this->betsCount;
	}


}