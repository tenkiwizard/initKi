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
	public function response()
	{
		$data['message'] = 'Unauthorized';
		$response = Response::forge(View::forge('errors/exception', $data), 401);
		return $response;
	}
}
