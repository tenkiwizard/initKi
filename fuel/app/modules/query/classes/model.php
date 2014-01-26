<?php
/**
 * Model abstract class
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

abstract class Model implements Model_Interface
{
	protected static $_table_name = '';
	protected static $_properties = array();

	protected static $query = null;
	protected static $query_builder = null;
	protected static $query_conditions = array( // needs this?
		'uses_orm_query' => true,
		'or_where_groups' => array(),
		'period_property' => 'updated_at',
		'max_limit' => 1000,
		'selects' => array(),
		'wheres' => array(),
		'or_wheres' => array(),
		);

	public static function table()
	{
		// Sourced from \Orm\Model::table() ;)
		if (empty(static::$_table_name))
		{
			static::$_table_name = \Inflector::tableize(get_called_class());
		}

		return static::$_table_name;
	}

	public static function properties()
	{
		// Sourced from \Orm\Model::properties()
		if (empty(static::$_properties))
		{
			throw new \FuelException(
				'Listing fields failed, you have to set the model properties with a '.
				'static $_properties setting in the model.'
				);
		}

		$properties = static::$_properties;
		foreach ($properties as $key => $p)
		{
			if (is_string($p))
			{
				unset($properties[$key]);
				$properties[$p] = array();
			}
		}

		static::$_properties = $properties;
		return static::$_properties;
	}

	public static function query()
	{
		// Implement in sub class
	}

	public static function query_conditions()
	{
		return static::$query_conditions;
	}

	/**
	 * Called by Builder::build() if this function exists
	 */
	//public static function convert_params(array &$params)
}
