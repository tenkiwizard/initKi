<?php
/**
 * Gitlab users model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Chatwork_Rooms extends Model_Chatwork
{
	protected static $_table_name = 'rooms';

	public function build_query(array $params = array())
	{
		static::$_table_name .= '/'.$params['room_id'].'/messages';
		\Arr::delete($params, 'room_id');

		return parent::build_query($params);
	}
}
