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
	public function response()
	{
		$data['message'] = 'Forbidden';
		$response = Response::forge(View::forge('errors/exception', $data), 403);
		return $response;
	}
}
