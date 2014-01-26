<?php

/**
 * HTTP Session timeout exception
 *
 * @package  app
 * @author kawamura.hryk
 * @author nakaishi.nryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class HttpSessionTimeoutException extends HttpException
{
	public function response()
	{
		$data['message'] = 'SessionTimeout';
		$response = Response::forge(View::forge('errors/exception', $data), 400);
		return $response;
	}
}
