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
	public function response()
	{
		$data['message'] = 'MethodNotAllowed';
		$response = Response::forge(View::forge('errors/exception', $data), 405);
		return $response;
	}
}
