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

class Model_Redmine extends \Query\Model_Api
{
	const CONFIG_KEY_NAME = 'api_key';

	public function __construct()
	{
		\Config::load('zenkins::redmine', 'redmine');
		if ($api_key = \Config::get('redmine.'.static::CONFIG_KEY_NAME))
		{
			static::$query['key'] = $api_key;
		}

		if (! static::$base_url)
		{
			static::$base_url = \Config::get('redmine.host');
		}

		parent::__construct();
	}

	public function api_key($api_key = null)
	{
		$api_key and static::$query['key'] = $api_key;
		return $this;
	}
}
