<?php namespace Three9Dice\Interfaces;


use GuzzleHttp\Client;

/**
 * Interface ConnectorInterface
 * @package Three9Dice\Interfaces
 */
interface ConnectorInterface
{
	/**
	 * @param $method
	 * @param $params
	 *
	 * @return mixed
	 */
	public function request( $method, $params );

	/**
	 * @return Client
	 */
	public function getClient();

	/**
	 * @param Client $guzzleClient
	 *
	 * @return self
	 */
	public function setClient( Client $guzzleClient );

}