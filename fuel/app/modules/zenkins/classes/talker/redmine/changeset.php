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
	private static $things = array();

	private static $api_key = '';

	public static function forge($api_key = null)
	{
		return new static($api_key);
	}

	public function __construct($api_key = null)
	{
		$api_key and static::$api_key = $api_key;
		// Get from config file
	}

	public function __toString()
	{
		return \Format::forge(static::$things)->to_json();
	}

	public function talk(array $things)
	{
		static::$things = $things;
		$params = array_merge(array('key' => static::$api_key), static::$things);
		$api_name = 'fetch_changesets';
		\Initki\Api::base_url('https://red.il-tools.interlink.ne.jp/sys/');
		$results = \Initki\Api::$api_name($params)->body;
		return $results;
	}
}
