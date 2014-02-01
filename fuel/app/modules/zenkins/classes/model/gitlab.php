<?php
/**
 * Gitlab model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Gitlab extends \Query\Model_Api
{
	const CONFIG_KEY_NAME = 'private_token';

	public function __construct()
	{
		\Config::load('zenkins::gitlab', 'gitlab');
		if ($api_key = \Config::get('gitlab.'.static::CONFIG_KEY_NAME))
		{
			static::$query['private_token'] = $api_key;
		}

		if (! static::$base_url)
		{
			static::$base_url = \Config::get('gitlab.host');
		}

		parent::__construct();
	}

	public function api_key($api_key = null)
	{
		$api_key and static::$query['private_token'] = $api_key;
		return $this;
	}
}
