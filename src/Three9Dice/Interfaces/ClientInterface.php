<?php namespace Three9Dice\Interfaces;

/**
 * Interface ClientInterface
 * @package Three9Dice\Interfaces
 */
interface ClientInterface
{
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