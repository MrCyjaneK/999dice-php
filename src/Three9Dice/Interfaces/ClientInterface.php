<?php namespace Three9Dice\Interfaces;

/**
 * Interface ClientInterface
 * @package Three9Dice\Interfaces
 */
interface ClientInterface
{
	/**
	 * @param UserInterface $user
	 *
	 * @return self
	 */
	public function setUser( UserInterface $user );

	/**
	 * @return UserInterface
	 */
	public function getUser();

	/**
	 * @param $sessionCookie
	 *
	 * @return mixed
	 */
	public function setSessionCookie( $sessionCookie );

	/**
	 * @return mixed
	 */
	public function getSessionCookie();

	/**
	 * @param $method
	 * @param $params
	 *
	 * @return mixed
	 */
	public function sessionRequest( $method, $params );


}