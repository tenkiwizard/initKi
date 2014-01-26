<?php

/**
 * Extended Response class
 *
 * @package app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class Response extends Fuel\Core\Response
{
	/**
	 * @override
	 */
	public static function redirect($url = '', $method = 'location', $code = 302)
	{
		$response = new static;

		$response->set_status($code);

		if (strpos($url, '://') === false)
		{
			$url = $url !== '' ? \Uri::create($url) : \Uri::base();
		}

		strpos($url, '*') !== false and $url = \Uri::segment_replace($url);

		// Add query string support to Fuel\Core
		if (Input::get())
		{
			$url .= '?'.http_build_query(Input::get());
		}

		if ($method == 'location')
		{
			$response->set_header('Location', $url);
		}
		elseif ($method == 'refresh')
		{
			$response->set_header('Refresh', '0;url='.$url);
		}
		else
		{
			return;
		}

		$response->send(true);
		exit;
	}
}
