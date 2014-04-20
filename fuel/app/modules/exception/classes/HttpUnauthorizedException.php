<?php

/**
 * HTTP Unauthorized exception
 *
 * @package  app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class HttpUnauthorizedException extends HttpException
{
	protected static $http_status = 401;
	protected static $data = array(
		'message' => 'Unauthorized',
		);
}
