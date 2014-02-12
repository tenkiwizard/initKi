<?php
/**
 * Http class treats HTTP request / response
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Http
{
	protected static $configs = array();

	protected static $request = null;
	protected static $response = null;

	protected static $additional_headers = array();

	public static function forge($url, $method = 'get', $auto_format = true)
	{
		return new static($url, $method, $auto_format);
	}

	public function __construct($url, $method = 'get', $auto_format = true)
	{
		static::$configs = compact('url', 'method', 'auto_format');
	}

	public static function configure(array $configs = null)
	{
		if ( ! is_null($configs))
		{
			foreach ($configs as $key => $value)
			{
				static::$configs[$key] = $value;
			}
		}

		return static::$configs;
	}

	public function request(array $params = null)
	{
		static::$request = \Request::forge(static::$configs['url'], 'curl')
			->set_auto_format(static::$configs['auto_format'])
			->set_method(static::$configs['method']);
		if ( ! empty($params))
		{
			static::$request->set_params($params);
		}

		\Log::debug(
			'CURL_PARAMETERS => '.\Format::forge($params)->to_json(),
			__METHOD__);

		try
		{
			static::$response = $this->execute();
		}
		catch (\HttpException $e)
		{
			static::$response = $e->response();
			\Log::debug(
				'CURL_ERROR => '.\Format::forge(static::$response)->to_json(),
				__METHOD__);
		}

		return $this;
	}

	public function additional_headers(array $additional_headers)
	{
		static::$additional_headers = $additional_headers;
		return $this;
	}

	protected function execute()
	{
		// TODO 危険！設定ファイルなどによる切り替えが必要？
		static::$request->set_options(array(
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			));

		foreach (static::$additional_headers as $header => $content)
		{
			static::$request->set_header($header, $content);
			\Log::debug('CURL_HEADER => '.$header.': '.$content, __METHOD__);
		}

		$response = static::$request->execute()->response();
		\Log::debug(
			'CURL_GETINFO => '.
			\Format::forge(static::$request->response_info())->to_json(),
			__METHOD__);
		return $response;
	}

	public static function response()
	{
		return static::$response;
	}

	public static function correct_protocol($needs_ssl, $exit_when_incorrect = false)
	{
		if ($needs_ssl)
		{
			if (static::protocol() !== 'https')
			{
				if ($exit_when_incorrect)
				{
					throw new \HttpNotFoundException();
				}

				return static::redirect(
					preg_replace('/^http/i', 'https', static::current()));
			}
		}
		else
		{
			if (static::protocol() !== 'http')
			{
				if ($exit_when_incorrect)
				{
					throw new \HttpNotFoundException();
				}

				return static::redirect(
					preg_replace('/^https/i', 'http', static::current()));
			}
		}
	}

	protected static function protocol()
	{
		return \Input::protocol();
	}

	protected static function current()
	{
		return \Uri::current();
	}

	protected static function redirect($url)
	{
		\Response::redirect($url);
	}

	public static function no_cache(\Response $response)
	{
		$response->set_header(
			'Cache-Control',
			'no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
		$response->set_header('Pragma', 'no-cache');
		$response->set_header('Expires', 'Thu, 19 Nov 1981 08:52:00 GMT');
	}

	public static function no_sniff(\Response $response)
	{
		$response->set_header('X-Content-Type-Options', 'nosniff');
	}
}
