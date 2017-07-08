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

    /** @var int */
    private $currentAmount;

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
     * @param float         $startAmountCoef
     * @param string        $currency
     */
    public function __construct(
        UserInterface $user,
        $startAmountCoef = 0.0000001,
        $currency = Constant::CURRENCY_BTC
    ) {
        parent::__construct($user);

        $this->currency = $currency;

        $balance = $this->getClient()->getBalance($this->currency);
        $this->setStartBalance($balance['Balance']);

        $startAmount = $this->getStartBalance() * $startAmountCoef;

        if ($startAmount < 1 || $startAmount > $this->getStartBalance() / 1000) {
            throw new \InvalidArgumentException("Invalid amount value: " . $startAmount);
        }

        $this->startAmount = $startAmount;
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
        while ($count--) {
            $bet += pow(2, $count);
        }

        return $bet;
    }


    /**
     * @param callable|null $callback
     */
    public function start(callable $callback = null)
    {
        if ($this->isWork()) {
            return;
        }

        $this->initStartWorkTime();

        $this->isWork = true;

        $bet = new Bet(
            $this->startAmount,
            $this->currency
        );

        $chance = 15;

        while ($this->isWork) {
            $bet->setGuessRange(GuessRange::generateRandom($chance));

            $this->changeProfit(-$bet->getAmount());
            if ($this->getProfit() < $this->getMaxDrawdown()) {
                $this->maxValues[self::DRAWDOWN] = $this->getProfit();
            }

            if ($bet->getAmount() > $this->getMaxBet()) {
                $this->maxValues[self::BET] = $bet->getAmount();
            }

            $betResult = $this->getClient()->placeBet($bet);

            if ($betResult['PayOut'] == 0) {

                $this->currentDepth++;

                if ($this->currentDepth > $this->maxDepth) {
                    $this->maxDepth = $this->currentDepth;
                }

            } else {
                $this->changeProfit($betResult['PayOut']);
                $this->currentDepth = 1;

                if ($this->getBalance() > $this->getMaxBalance()) {
                    $this->maxValues[self::BALANCE] = $this->getBalance();
                }

                $this->iterateWinCount();
            }

            $bet->setAmount($this->generateBetAmount($bet));

            $this->iterateBetCount();

            if ($callback) {
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
     * @param Bet $bet
     *
     * @return int
     */
    public function generateBetAmount(Bet $bet): int
    {
        $depth = $this->getCurrentDepth();
        $lastBet = $bet->getAmount();

        $nextBet = $this->getStartAmount();

        if ($depth > 2) {
            $nextBet = $lastBet * 1.55;
        }

        if ($depth > 4) {
            $nextBet = $lastBet * 1.45;
        }

        if ($depth > 15) {
            $nextBet = $lastBet * 1.22;
        }

        if ($depth > 20) {
            $nextBet = $lastBet * 1.2;
        }

        if ($depth > 29) {
            $nextBet = $lastBet * 1.19;
        }

        if ($depth > 39) {
            $nextBet = $lastBet * 1.18;
        }

        if ($depth > 50) {
            $nextBet = $lastBet * 1.17;
        }

        return (int)$nextBet;
    }
}