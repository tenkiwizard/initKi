<?php
/**
 * Redmine talker
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Talker_Redmine_Changeset
{
	private static $model = 'Zenkins\Model_Redmine_Changeset';
	private static $things = array();
	private static $api_key = null;

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

	public function talk(array $things)
	{
		static::$things = $things;
		$model = static::$model;
		return $model::forge()
			->api_key(static::$api_key)
			->build_query(static::$things)
			->get();
	}
}
