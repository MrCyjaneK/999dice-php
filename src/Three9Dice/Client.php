<?php namespace Three9Dice;

use Three9Dice\Bet\Bet;
use Three9Dice\Component\AbstractClient;
use Three9Dice\Exception\Three9DiceException;
use Three9Dice\Interfaces\BetInterface;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class Client
 * @package Three9Dice
 */
class Client extends AbstractClient
{

	/**
	 * Client constructor.
	 */
	public function __construct( UserInterface $user = null )
	{
		$this->createConnector();

		if( $user )
		{
			$this->setUser($user);
			$this->login();
		}
	}

	/**
	 * @return bool
	 */
	protected function login()
	{
		$params = [
			'Key' => $this->getUser()->getApiKey(),
		    'Username' => $this->getUser()->getUsername(),
		    'Password' => $this->getUser()->getPassword()
		];
		if( $totp = $this->getUser()->getTotp() ) $params['Totp'] = $totp;

		$result = $this->getConnector()->request( Constant::METHOD_LOGIN, $params );

		$this->setSessionCookie($result['SessionCookie']);
		return true;
	}

	/**
	 * @param $method
	 * @param $params
	 *
	 * @return array
	 * @throws Three9DiceException
	 */
	public function sessionRequest($method, $params)
	{
		$sessionCookie = $this->getSessionCookie();
		if( empty($sessionCookie) )
		{
			throw new Three9DiceException('Invalid or empty client session cookie');
		}
		$params = array_merge([ 's' => $sessionCookie ], $params);

		return $this->getConnector()->request($method, $params);
	}

	/**
	 * @param Bet $bet
	 *
	 * @return array
	 */
	public function placeBet( Bet $bet )
	{
		return $this->sessionRequest( Constant::METHOD_PLACE_BET, $bet->getRequestParams() );
	}

	/**
	 * @param string $currency
	 *
	 * @return array
	 */
	public function getDeposit( $currency = Constant::CURRENCY_BTC )
	{
		return $this->sessionRequest( Constant::METHOD_GET_DEPOSIT_ADDRESS, [
			"Currency" => $currency
		] );
	}
        /**
	 * @param string $currency
	 *
	 * @return array
	 */
	public function makeWithdraw( $currency = Constant::CURRENCY_BTC , $address = "no")
	{
		return $this->sessionRequest( Constant::METHOD_WITHDRAW, [
			"Amount" => $amount,
                        "Address" => $address,
                        "Currency" => $currency
		] );
	}

}
