<?php
/**
 * Class method name <-> cURL request /response wrapper
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Api
{
	protected static $base_url = '';
	protected static $method = 'get';
	protected static $auto_format = true;

	public static function base_url($base_url = null)
	{
		if ( ! is_null($base_url))
		{
			static::$base_url = $base_url;
		}

		if (empty(static::$base_url))
		{
			\Config::load('initki::resource', 'resource');
			$base_url = \Config::get('resource.api.base_url');
			static::$base_url = $base_url;
		}

		return static::$base_url;
	}

	public static function url($call, $replace_to_slash = '')
	{
		$url = static::$base_url;
		if ($replace_to_slash)
		{
			$call = str_replace($replace_to_slash, '/', $call);
		}
		$url .= $call;
		return $url;
	}

	public static function __callStatic($func, $args)
	{
		$params = array_shift($args);
		if (property_exists(get_called_class(), $func))
		{
			if ( ! is_null($params))
			{
				// Set my property value if I have
				static::${$func} = $params;
			}

			return static::${$func};
		}

		return static::http(static::url($func), $params);
	}

	protected static function http($url, array $params = null)
	{
		return Http::forge($url, static::$method, static::$auto_format)
			->request($params)->response();
	}
}
