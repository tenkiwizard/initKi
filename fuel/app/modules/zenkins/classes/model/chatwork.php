<?php
/**
 * ChatWork model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Chatwork extends Model
{
	const CONFIG_SECTION = 'chatwork';
	const CONFIG_API_KEY = 'X-ChatWorkToken';

	protected static function api($name, $method = 'get')
	{
		static::$additional_headers[static::CONFIG_API_KEY] =
			static::$query[static::CONFIG_API_KEY];
		unset(static::$query[static::CONFIG_API_KEY]);
		return parent::api($name, $method);
	}
}
