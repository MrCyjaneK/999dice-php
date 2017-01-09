<?php namespace Three9Dice\Component;

use Three9Dice\Connector;
use Three9Dice\Interfaces\ConnectorInterface;
use Three9Dice\Interfaces\ClientInterface;
use Three9Dice\Interfaces\UserInterface;

/**
 * Class AbstractClient
 * @package Three9Dice\Component
 */
abstract class AbstractClient implements ClientInterface
{

	/** @var  UserInterface $user */
	private $user;

	/** @var ConnectorInterface $connector */
	private $connector;

	/** @var string $sessionCookie */
	private $sessionCookie;

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
	 * @param $sessionCookie
	 *
	 * @return $this
	 */
	public function setSessionCookie( $sessionCookie )
	{
		$this->sessionCookie = $sessionCookie;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSessionCookie()
	{
		return $this->sessionCookie;
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

}