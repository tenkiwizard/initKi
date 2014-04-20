<?php

/**
 * HTTP Invalid parameter exception <<VS. bad parameter normally>>
 *
 * @package  app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class HttpInvalidParameterException extends HttpException
{
	protected static $data = array(
		'message' => 'Invalid Parameter',
		);

	protected function additional_data()
	{
		if ($invalids = array_keys(Validation::instance()->error())) // Experimental!
		{
			static::$data['invalids'] = $invalids;
		}
	}
}
