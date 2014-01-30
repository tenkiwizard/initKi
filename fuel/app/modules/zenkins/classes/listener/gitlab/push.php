<?php
/**
 * GitLab pushes listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Listener_Gitlab_Push
{
	private static $things = array();

	public static function forge()
	{
		return new static();
	}

	public function __construct()
	{
		static::$things = \Input::json();
		\Log::debug($this, __METHOD__);
	}

	public function __toString()
	{
		return \Format::forge(static::$things)->to_json();
	}

	public function listen($field = null)
	{
		return $field ? \Arr::get(static::$things, $field) : static::$things;
	}
}
