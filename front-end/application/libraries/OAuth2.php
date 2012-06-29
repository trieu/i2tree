<?php

include('OAuth2Client/Exception.php');
include('OAuth2Client/Token.php');
include('OAuth2Client/Provider.php');

/**
 * OAuth2.0
 *
 * @author Phil Sturgeon < @philsturgeon >
 */
class OAuth2 {

	/**
	 * Create a new provider.
	 *
	 *     // Load the Twitter provider
	 *     $provider = $this->oauth2->provider('twitter');
	 *
	 * @param   string   provider name
	 * @param   array    provider options
	 * @return  OAuth_Provider
	 */
	public static function provider($name, array $options = NULL)
	{
		$name = ucfirst(strtolower($name));

		include_once 'OAuth2Client/Provider/'.$name.'.php';

		$class = 'OAuth2_Provider_'.$name;

		return new $class($options);
	}

}