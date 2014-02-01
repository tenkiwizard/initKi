<?php
/**
 * Gitlab talker
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

abstract class Talker_Gitlab
{
	protected static $model = null;
	protected static $things = array();
	protected static $api_key = null;

	public static function forge($api_key = null)
	{
		return new static($api_key);
	}

	public function __construct($api_key = null)
	{
		$api_key and static::$api_key = $api_key;
	}

	public function __toString()
	{
		return \Format::forge(static::$things)->to_json();
	}

	public function talk(array $things = array())
	{
		static::$things = $things;
		$model = static::$model;
		return $model::forge()
			->api_key(static::$api_key)
			->build_query(static::$things)
			->get();
	}
}
