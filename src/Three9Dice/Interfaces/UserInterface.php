<?php namespace Three9Dice\Interfaces;

/**
 * Class UserInterface
 * @package Three9Dice\Interfaces
 */
interface UserInterface
{

	/**
	 * UserInterface constructor.
	 *
	 * @param $apiKey
	 * @param $username
	 * @param $password
	 * @param null $totp
	 */
	public function __construct( $apiKey, $username, $password, $totp = null );

	/**
	 * @return string
	 */
	public function getApiKey();

	/**
	 * @param string $apiKey
	 * @return self
	 */
	public function setApiKey( $apiKey );

	/**
	 * @return string
	 */
	public function getUsername();

	/**
	 * @param string $username
	 * @return self
	 */
	public function setUsername( $username );

	/**
	 * @return string
	 */
	public function getPassword();

	/**
	 * @param string $password
	 * @return string
	 */
	public function setPassword( $password);

	/**
	 * @return self
	 */
	public function getTotp();

	/**
	 * @param string $password
	 * @return string|null
	 */
	public function setTotp( $totp );
}