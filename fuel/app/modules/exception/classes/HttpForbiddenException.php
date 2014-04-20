<?php

/**
 * HTTP Forbidden exception
 *
 * @package  app
 * @author kawamura.hryk
 * @author nakaishi.nryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class HttpForbiddenException extends HttpException
{
	protected static $http_status = 403;
	protected static $data = array(
		'message' => 'Forbidden',
		);
}
