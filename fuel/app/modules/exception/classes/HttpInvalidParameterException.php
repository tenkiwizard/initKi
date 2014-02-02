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
	public function response()
	{
		$data['message'] = 'Invalid Parameter'.$this->additional_message();
		$response = Response::forge(View::forge('errors/exception', $data), 400);
		return $response;
	}

	private function additional_message()
	{
		$invalids = array_keys(Validation::instance()->error()); // experimental!
		$invalids[] = $this->getMessage();
		$additional = implode(',', $invalids);
		return ' ('.$additional.')';
	}
}
