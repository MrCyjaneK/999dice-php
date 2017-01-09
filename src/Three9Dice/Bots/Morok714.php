<?php

namespace Three9Dice\Bots;


use Three9Dice\Bet\Bet;
use Three9Dice\Constant;
use Three9Dice\GuessRange\GuessRange;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class Morok714
 * @package Three9Dice\Bots
 */
class Morok714 extends AbstractBot
{

	/** @var string $currency */
	private $currency;

	/** @var int $startAmount */
	private $startAmount;

	/** @var bool $isWork */
	private $isWork = false;

	/** @var int */
	private $currentDepth = 1;

	/** @var int */
	private $maxDepth = 0;

	/** @var null $depthOrient */
	private $depthOrient = null;

	/** @var int */
	private $currentAmount;

	private $strategy = [
		0 => [28, 0.4, 0]
	];

	private $curChance = 0;

	const DRAWDOWN = 'drawdown';
	const BALANCE = 'balance';
	const BET = 'bet';

	/** @var int[] $maxValues */
	private $maxValues = [
		self::DRAWDOWN => 0,
		self::BALANCE => 0,
		self::BET => 0
	];

	/**
	 * MartingaleBot constructor.
	 *
	 * @param UserInterface $user
	 * @param int $startAmount
	 * @param string $currency
	 * @param bool $depthOrient
	 */
	public function __construct(
		UserInterface $user,
		$startAmount = 1,
		$currency = Constant::CURRENCY_BTC,
		$depthOrient = false
	)
	{
		parent::__construct($user);

		$this->currency = $currency;
		$this->startAmount = $startAmount;
		$this->depthOrient = $depthOrient;

		$balance = $this->getClient()->getBalance($this->currency);
		$this->setStartBalance($balance['Balance']);
	}

	/**
	 * @return int
	 */
	public function getStartAmount(): int
	{
		return $this->startAmount;
	}

	/**
	 * @return int
	 */
	public function getMaxDrawdown()
	{
		return $this->maxValues[self::DRAWDOWN];
	}

	/**
	 * @return int
	 */
	public function getMaxBet()
	{
		return $this->maxValues[self::BET];
	}

	/**
	 * @return int
	 */
	public function getMaxBalance()
	{
		return $this->maxValues[self::BALANCE];
	}

	/**
	 * @return bool
	 */
	public function isWork()
	{
		return $this->isWork;
	}

	/**
	 * @param int $count
	 *
	 * @return int
	 */
	public static function getCoef($count): int
	{
		$bet = 0;
		while($count--)
		{
			$bet += pow(2, $count);
		}

		return $bet;
	}


	/**
	 * @param callable|null $callback
	 */
	public function start(callable $callback = null)
	{
		if($this->isWork())
		{
			return;
		}

		$this->initStartWorkTime();

		$this->isWork = true;

		$bet = new Bet(
			$this->startAmount,
			$this->currency
		);

		list($chance, $upLoss, $upWin) = $this->getStrategy(0);

		while($this->isWork)
		{
			$bet->setGuessRange(GuessRange::generateRandom($chance));

			$this->changeProfit(-$bet->getAmount());
			if($this->getProfit() < $this->getMaxDrawdown())
			{
				$this->maxValues[self::DRAWDOWN] = $this->getProfit();
			}
			if($bet->getAmount() > $this->getMaxBet())
			{
				$this->maxValues[self::BET] = $bet->getAmount();
			}
			$betResult = $this->getClient()->placeBet($bet);

			if($betResult['PayOut'] == 0)
			{
				$bet->setAmount($bet->getAmount() * (1 + $upLoss));
				$this->currentDepth++;

				if($this->currentDepth > $this->maxDepth)
				{
					$this->maxDepth = $this->currentDepth;
				}
			}
			else
			{
				$this->changeProfit($betResult['PayOut']);
				$this->currentDepth = 1;
				$this->startAmount *= (1 + $upWin);
				$bet->setAmount($this->startAmount);

				if($this->getBalance() > $this->getMaxBalance())
				{
					$this->maxValues[self::BALANCE] = $this->getBalance();
				}
			}

			$this->iterateBetCount();

			if($callback)
			{
				$callback($this, $betResult);
			}
			usleep(10000);
		}
	}

	/**
	 * @return $this
	 */
	public function stop()
	{
		$this->isWork = false;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getMaxDepth()
	{
		return $this->maxDepth;
	}

	/**
	 * @return int
	 */
	public function getCurrentDepth()
	{
		return $this->currentDepth;
	}

	/**
	 * @param int $index
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getStrategy(int $index = 0)
	{
		if(empty($this->strategy[$index]))
		{
			throw new \Exception("Strategy not found");
		}

		return $this->strategy[$index];
	}
}