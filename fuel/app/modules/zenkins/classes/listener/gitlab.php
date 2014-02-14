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

abstract class Listener_Gitlab
{
	protected $things = array();

	public static function forge()
	{
		return new static();
	}

	public function __construct()
	{
		$this->things = (array) $this->things();
		\Log::debug($this, __METHOD__);
	}

	protected function things()
	{
		return \Input::json();
	}

	public function __toString()
	{
		return \Format::forge($this->things)->to_json();
	}

	public function listen($field = null)
	{
		return $field ? \Arr::get($this->things, $field) : $this->things;
	}
}
