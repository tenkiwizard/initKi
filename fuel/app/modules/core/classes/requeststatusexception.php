<?php

/**
 * Exception thrown in Fuel\Core\Request_Curl
 * overriden can switch error status codes
 *
 * @package  app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class RequestStatusException extends \HttpException
{
	public function response()
	{
		return Response::forge(
			static::code_to_message($this->getCode()), $this->getCode());
	}

	private static function code_to_message($code)
	{
		$statuses = Response::$statuses;
		if (array_key_exists($code, $statuses))
		{
			return $statuses[$code];
		}

		return 'Unknown Error';
	}
}
