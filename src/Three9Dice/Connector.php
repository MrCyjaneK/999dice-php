<?php namespace Three9Dice;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use Three9Dice\Exception\RequestException;
use Three9Dice\Interfaces\ConnectorInterface;

/**
 * Class Connector
 * @package Three9Dice
 */
class Connector implements ConnectorInterface
{
	const DOMAIN = 'https://www.999dice.com/';
	const URL = '/api/web.aspx';


	/** @var GuzzleClient $client */
	private $client;


	protected static $errorsMap = [
		'TooFast',
		'TotpFailure',
		'InvalidApiKey',
		'LoginRequired',
		'LoginInvalid',
	    'AccountHasUser',
		'UsernameTaken',
		'WrongPassword',
	    'TooSmall',
		'InsufficientFunds',
	    'ChanceTooHigh',
		'ChanceTooLow',
	    'InsufficientFunds',
		'NoPossibleProfit',
		'MaxPayoutExceeded',
	    'Seed'
	];

	/**
	 * Connector constructor.
	 */
	public function __construct()
	{
		$this->setClient( new GuzzleClient(
			[
				'base_uri' => self::DOMAIN,
//			    'timeout' => 20.0
			]
		) );
	}

	/**
	 * @return GuzzleClient
	 */
	public function getClient()
	{
		return $this->client;
	}

	/**
	 * @param GuzzleClient $guzzleClient
	 */
	public function setClient( GuzzleClient $guzzleClient )
	{
		$this->client = $guzzleClient;
		return $this;
	}

	/**
	 * @param array $content
	 *
	 * @return bool|mixed
	 */
	protected function checkRequestError(array $content)
	{
		if( array_key_exists('error', $content) )
		{
			return $content['error'];
		}

		foreach( self::$errorsMap as $key )
		{
			if( isset($content[$key]) ) return $key;
		}

		return false;
	}


	/**
	 * @param $method
	 * @param $params
	 *
	 * @return array|mixed
	 * @throws RequestException
	 */
	public function request($method, $params)
	{
		$body = array_merge([
			'a' => $method
		], $params);

		$response = $this->getClient()->post(self::URL, [
			'form_params' => $body
		]);

		$rawBodyResponse = $response->getBody()->getContents();
		$body = json_decode($rawBodyResponse, true);

		if( $error = $this->checkRequestError($body) )
		{
			throw new RequestException($error);
		}

		return $body;
	}
}