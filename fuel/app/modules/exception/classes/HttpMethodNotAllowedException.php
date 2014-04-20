<?php

/**
 * HTTP Method not allowed exception
 *
 * @package  app
 * @author kawamura.hryk
 * @author nakaishi.nryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class HttpMethodNotAllowedException extends HttpException
{
	protected static $http_status = 405;
	protected static $data = array(
		'message' => 'MethodNotAllowed',
		);
}
