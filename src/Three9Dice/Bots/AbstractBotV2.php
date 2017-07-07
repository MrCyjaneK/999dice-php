<?php

namespace Three9Dice\Bots;

use Three9Dice\Client;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class AbstractBotV2
 * @package Three9Dice\Bots
 */
abstract class AbstractBotV2
{
    /** @var Client $client */
    private $client;

    /** @var \DateTime $workTimer */
    private $workTimer;

    /** @var bool $isWork */
    protected $isWork = false;


    /** @var int $baseBet */
    private $baseBet;

    /** @var string $currency */
    private $currency;


    /** @var int $startBalance */
    private $startBalance = 0;

    /**
     * AbstractBotV2 constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->client = new Client($user);
        $this->workTimer = new \DateTime();
    }

    /**
     * @return callable
     */
    protected abstract function getWorkProof(): callable;

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param callable (array $betResult, AbstractBotV2 $abstractBot) $callback
     */
    public function start(callable $callback)
    {
        $this->isWork = true;

        $workProof = $this->getWorkProof();

        while ($this->isWork) {
            $betResult = $workProof();

            $callback($this, $betResult);
        }
    }


    public function stop()
    {
        $this->isWork = false;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    protected function setCurrency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param int $baseBet
     *
     * @return $this
     */
    protected function setBaseBet(int $baseBet)
    {
        $this->baseBet = $baseBet;

        return $this;
    }

    /**
     * @return int
     */
    public function getBaseBet(): int
    {
        return $this->baseBet;
    }

    /**
     * @return \DateTime
     */
    public function getTimer()
    {
        return $this->workTimer;
    }

    /**
     * @param int $startBalance
     *
     * @return $this
     */
    protected function setStartBalance(int $startBalance)
    {
        $this->startBalance = $startBalance;

        return $this;
    }

    /**
     * @return int
     */
    public function getStartBalance(): int
    {
        return $this->startBalance;
    }
}