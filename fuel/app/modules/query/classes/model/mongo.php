<?php
/**
 * Model abstract class with query building uses Mongo_Db
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

abstract class Model_Mongo extends Model
{
	public static function forge($database = null)
	{
		return new static($database);
	}

	public function __construct($database = null)
	{
		$database = $database ?: 'default';
		static::$query = Mongo_Db::instance($database);
		static::$query_builder = Builder_Mongo::forge($this);
	}

	public static function query()
	{
		return static::$query;
	}

	public function build_query(array $params = array())
	{
		static::$query_builder->is_valid($params)->build();
		return $this;
	}

	public function get()
	{
		return static::$query->get(static::$_table_name);
	}
}
