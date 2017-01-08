<?php namespace Three9Dice;

use Three9Dice\Interfaces\ConnectorInterface;
use Three9Dice\Interfaces\ClientInterface;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class Client
 * @package Three9Dice
 */
class Client implements ClientInterface
{
	/** @var  UserInterface $user */
	private $user;

	/**
	 * @var ConnectorInterface $connector
	 */
	private $connector;

	/**
	 * @var string
	 */
	private $sessionCookie;

	/**
	 * Client constructor.
	 */
	public function __construct( UserInterface $user )
	{
		$this->setUser($user);
		$this->createConnector();
		$this->login();
	}

	/**
	 * @param UserInterface $user
	 *
	 * @return $this
	 */
	public function setUser(UserInterface $user)
	{
		$this->user = $user;
		return $this;
	}

	/**
	 * @return UserInterface
	 */
	public function getUser()
	{
		return $this->user;
	}


	/**
	 * @return Connector
	 */
	protected function createConnector()
	{
		return $this->connector = new Connector();
	}

	/**
	 * @return ConnectorInterface
	 */
	public function getConnector()
	{
		return $this->connector;
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

		$result = $this->getConnector()->request( Connector::METHOD_LOGIN, $params );

		$sessionCookie = $result['SessionCookie'];

		return true;
	}


}