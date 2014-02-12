<?php
/**
 * 
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Controller extends \Initki\Controller_Restful
{
	protected static $needs_ssl = true;

	protected $things = array();

	public function before()
	{
		parent::before();
		$this->things();
		\Lang::load('zenkins::vocabulary');
	}

	public function get_index()
	{
		//
	}

	protected function things()
	{
		foreach (\Input::param() as $key => $val)
		{
			$this->things[$key] = $val;
		}
	}

	protected function override($key, $val, $required = false)
	{
		$return = \Arr::get($this->things, $key)
			? \Arr::get($this->things, $key)
			: $val;
		if ($required and $return === null)
		{
			throw new \HttpInvalidParameterException('"'.$key.'" is required');
		}

		return $return;
	}
}
