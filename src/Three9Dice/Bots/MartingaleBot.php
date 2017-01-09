<?php namespace Three9Dice\Bots;


use Three9Dice\Bet\Bet;
use Three9Dice\Client;
use Three9Dice\Constant;
use Three9Dice\GuessRange\GuessRange;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class MartingaleBot
 * @package Three9Dice\Bots
 */
class MartingaleBot extends AbstractBot
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


	/**
	 * MartingaleBot constructor.
	 *
	 * @param UserInterface $user
	 * @param int           $startAmount
	 * @param string        $currency
	 * @param bool          $depthOrient
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


		while($this->isWork)
		{
			$bet->setGuessRange(GuessRange::generateRandom(49.95));

			$this->changeProfit(-$bet->getAmount());
			$betResult = $this->getClient()->placeBet($bet);

			if($betResult['PayOut'] == 0)
			{
				$bet->setAmount($bet->getAmount() * 2);
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

				if($this->depthOrient && $this->depthOrient > 8)
				{
					$this->startAmount = floor($this->getBalance() / self::getCoef($this->depthOrient));
				}

				$bet->setAmount($this->startAmount);
			}

			$this->iterateBetCount();

			if($callback)
			{
				$callback($this, $betResult);
			}
			usleep(1000);
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

}