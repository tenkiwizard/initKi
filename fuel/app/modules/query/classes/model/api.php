<?php
/**
 * Model abstract class via external web API
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @author ezaki3
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

abstract class Model_Api extends Model
{
	protected static $base_url = '';
	protected static $query = array();

	public static function forge()
	{
		return new static();
	}

	public function __construct()
	{
		\Initki\Api::base_url(static::$base_url);
		static::$query_builder = Builder_Api::forge($this); /// Do you use it?
	}

	public static function query()
	{
		return static::$query;
	}

	public function build_query(array $params = array())
	{
		static::$query = array_merge(static::$query, $params);
		static::$query_builder->validate($params)->build();
		return $this;
	}

	public function get()
	{
		return static::request();
	}

	public function get_one()
	{
		$results = $this->get();
		return \Arr::get($results, 0, array());
	}

	public function post()
	{
		return static::request('post');
	}

	public function put()
	{
		return static::request('put');
	}

	private static function request($method = 'get')
	{
		$api_name = static::table();
		$results = static::api($api_name, $method);
		if ( ! is_array($results))
		{
			// HTTP status is not 200
			$results = array();
		}

		return $results;
	}

	protected static function api($name, $method = 'get')
	{
		static $configs = null;
		if (is_null($configs))
		{
			// TODO Verify behavior
			\Config::load('Query::config', 'query');
			$configs['api_cache'] = \Config::get('query.api_cache');
			$configs['api_cache_lifetime'] = \Config::get('query.api_cache_lifetime');
		}

		if ($configs['api_cache'])
		{
			return \Cache::call(
				static::key($method, $name, static::$query),
				'Query\Model_Api::_api', // 'static::_api' is OK?
				array($name, $method),
				$configs['api_cache_lifetime']);
		}

		\Initki\Api::method($method);
		return \Initki\Api::$name(static::$query)->body;
	}
}
