<?php

/**
 * Extended HTTP exception
 *
 * @package  app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
abstract class HttpException extends \Fuel\Core\HttpException
{
	protected static $http_status = 400;
	protected static $data = array(
		'message' => '',
		);

	public function response()
	{
		$response = Response::forge(
			View::forge('errors/exception', static::$data),
			static::$http_status);
		return $response;
	}

	/**
	 * @override
	 */
	public function handle()
	{
		static::$data['message'] =
			$this->getMessage() ?: \Arr::get(static::$data, 'message');
		static::$http_status = $this->getCode() ?: static::$http_status;
		method_exists($this, 'additional_data') and $this->additional_data();

		$controller = Request::forge()->main()->controller_instance;
		if ($controller instanceof \Initki\Controller_Restful)
		{
			$response = $controller->force_response(static::$data, static::$http_status);

			// fire any app shutdown events
			\Event::instance()->trigger('shutdown', '', 'none', true);
		}
		else
		{
			// get the exception response
			$response = $this->response();

			// fire any app shutdown events
			\Event::instance()->trigger('shutdown', '', 'none', true);

			// fire any framework shutdown events
			\Event::instance()->trigger('fuel-shutdown', '', 'none', true);
		}

		// send the response out
		$response->send(true);
	}
}
