<?php
/**
 * Model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

abstract class Model extends \Query\Model_Api
{
	const CONFIG_SECTION = '';
	const CONFIG_API_KEY = 'api_key';

	public function __construct()
	{
		\Config::load('zenkins::resource', 'resource');
		$api_key = \Config::get(
			'resource.'.static::CONFIG_SECTION.'.'.static::CONFIG_API_KEY);
		$api_key and static::$query[static::CONFIG_API_KEY] = $api_key;
		if (! static::$base_url)
		{
			static::$base_url = \Config::get(
				'resource.'.static::CONFIG_SECTION.'.host');
		}

		parent::__construct();
	}

	public function api_key($api_key = null)
	{
		$api_key and static::$query[static::CONFIG_API_KEY] = $api_key;
		return $this;
	}
}
