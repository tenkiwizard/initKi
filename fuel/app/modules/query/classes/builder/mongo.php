<?php
/**
 * Query builder sourced data from Mongo_Db
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

class Builder_Mongo extends Builder
{
	public function select(array $selects = null)
	{
		if ( ! is_null($selects))
		{
			static::$selects = $selects;
		}

		static::$query->select(static::$selects);
	}

	protected static function build_or_wheres(array &$params)
	{
		$or_where_groups = array();
		$used_params = array();
		foreach ($params as $key => $val)
		{
			if (array_key_exists($key, static::$or_where_groups))
			{
				if ( ! is_null($val))
				{
					$or_where_groups[static::$or_where_groups[$key]][$key] = $val;
					$used_params[] = $key;
				}
			}
		}

		foreach ($used_params as $used)
		{
			unset($params[$used]);
		}

		foreach ($or_where_groups as $index => $assoc)
		{
			$or_wheres = array();
			foreach ($assoc as $key => $val)
			{
				$or_wheres[$key] = $val;
			}

			static::$query->or_where($or_wheres);
		}
	}

	protected static function build_wheres(array &$params)
	{
		foreach ($params as $key => $val)
		{
			if ( ! is_null($val) and static::has_property($key))
			{
				if (strpos($val, ',') !== false)
				{
					/** @todo Not supported (or_where_groups && multiple value) YET! */
					static::$or_wheres[$key] = explode(',', $val);
				}
				else
				{
					static::$wheres[$key] = $val;
				}
			}
		}
	}

	protected static function add_wheres()
	{
		if ( ! empty(static::$wheres))
		{
			static::$query->where(static::$wheres);
		}

		if ( ! empty(static::$or_wheres))
		{
			// ここちと不安・・・Mongo_Db::or_where()が対応してるのかどうか。
			static::$query->or_where(static::$or_wheres);
		}
	}

	protected static function period(array $params)
	{
		// Not implemented yet
		// Remember `MongoDate` on PHP, `ISODate` on mongo shell
	}

	protected static function order(array $params)
	{
		$order = '';
		if (empty($params['order'])) return;
		$order = $params['order'];
		$direction = 'asc';
		if ( ! empty($params['direction']) and $params['direction'] == 'desc')
		{
			$direction = 'desc';
		}

		// Multiple column is not supported yet
		static::$query->order_by(array($order => $direction));
	}
}
