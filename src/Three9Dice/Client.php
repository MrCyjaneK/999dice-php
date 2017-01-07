<?php namespace Three9Dice;

use Three9Dice\Interfaces\ClientInterface;

/**
 * Class Client
 * @package Three9Dice
 */
class Client // implements ClientInterface
{
	/**
	 * @var string
	 */
	private $apiKey;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $totp;

	/**
	 * Client constructor.
	 *
	 * @param string $apiKey
	 * @param string $username
	 * @param string $password
	 * @param bool $totp
	 */
	public function __construct($apiKey, $username, $password, $totp = null )
	{
		$this->setApiKey($apiKey);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setTotp($totp);

		$this->login();
	}

	/**
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * @param string $apiKey
	 *
	 * @return $this
	 */
	public function setApiKey( $apiKey )
	{
		$this->apiKey = $apiKey;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 *
	 * @return Client
	 */
	public function setUsername( $username)
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 *
	 * @return Client
	 */
	public function setPassword( $password)
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTotp()
	{
		return $this->totp;
	}

	/**
	 * @param mixed $totp
	 *
	 * @return Client
	 */
	public function setTotp( $totp )
	{
		$this->totp = $totp;
		return $this;
	}

	/**
	 * Login
	 */
	protected function login()
	{
		return true;
	}


}