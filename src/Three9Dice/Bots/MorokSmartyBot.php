<?php

namespace Three9Dice\Bots;

use Three9Dice\Bet\Bet;
use Three9Dice\GuessRange\GuessRange;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class MorokSmartyBot
 * @package Three9Dice\Bots
 */
class MorokSmartyBot extends AbstractBotV2
{
    /**
     * MorokSmartyBot constructor.
     *
     * @param UserInterface $user
     * @param string        $currency
     * @param int           $baseBet
     */
    public function __construct(
        UserInterface $user,
        string $currency,
        int $baseBet = 1
    ) {
        parent::__construct($user);

        $this->setBaseBet($baseBet);
        $this->setCurrency($currency);

        $balance = $this->getClient()->getBalance($currency);
        $this->setStartBalance($balance['Balance']);
    }

    /**
     * @return callable
     */
    protected function getWorkProof(): callable
    {
        $bet = new Bet(
            $this->getBaseBet(),
            $this->getCurrency()
        );

        $bet->setGuessRange(GuessRange::generateRandom(15));

        return function () use (&$bet) {
            $betResult = $this->getClient()->placeBet($bet);

            return $betResult;
        };
    }

}