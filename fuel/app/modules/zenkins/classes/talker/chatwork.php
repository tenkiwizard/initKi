<?php
/**
 * Gitlab talker about users
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Talker_Chatwork extends Talker
{
	protected static $model = 'Zenkins\Model_Chatwork_Rooms';

	public function talk(array $things = array())
	{
		static::$things = $things;
		$model = static::$model;
		return $model::forge()
			->api_key(static::$api_key)
			->build_query(static::$things)
			->post();
	}
}
