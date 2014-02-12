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

class Model_Gitlab_Users extends Model_Gitlab
{
	protected static $_table_name = 'users';

	public function build_query(array $params = array())
	{
		if ($id = \Arr::get($params, 'id'))
		{
			static::$_table_name .= '/'.$id;
			\Arr::delete($params, 'id');
		}

		return parent::build_query($params);
	}
}
