<?php namespace Three9Dice;

use Three9Dice\Interfaces\UserInterface;

/**
 * Class User
 * @package Three9Dice
 */
class User implements UserInterface
{
	/** @var string */
	private $apiKey;

	/** @var string */
	private $username;

	/** @var string */
	private $password;

	/** @var string */
	private $totp;

	/**
	 * User constructor.
	 *
	 * @param $apiKey
	 * @param $username
	 * @param $password
	 * @param null $totp
	 */
	public function __construct( $apiKey, $username, $password, $totp = null )
	{
		$this->setApiKey($apiKey);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setTotp($totp);
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
	 * @return $this
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
	 * @return $this
	 */
	public function setPassword( $password)
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTotp()
	{
		return $this->totp;
	}

	/**
	 * @param mixed $totp
	 *
	 * @return $this
	 */
	public function setTotp( $totp )
	{
		$this->totp = $totp;
		return $this;
	}
}