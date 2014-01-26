<?php
/**
 * Code (id, number or so) <-> code name converter abstract class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class CodeTo
{
	protected static $list = array();
	protected static $model = null;
	protected static $cache = array();

	public static function set()
	{
		if (static::$model != get_called_class())
		{
			static::$model = get_called_class();
		}

		if (\Arr::get(static::$cache, static::$model)) return false;
		static::$cache[static::$model] = static::$list;
		return true;
	}

	/**
	 * Get all as assoc
	 */
	public static function get_all()
	{
		static::set();
		return static::$cache[static::$model];
	}

	/**
	 * Get name by code
	 */
	public static function to_name($code)
	{
		static::set();
		if ( ! array_key_exists($code, static::$cache[static::$model]))
		{
			return false;
		}

		if ( ! is_array(static::$cache[static::$model][$code]))
		{
			return static::$cache[static::$model][$code];
		}

		return static::to('name', array($code));
	}

	/**
	 * Get code by name
	 */
	public static function from_name($name)
	{
		static::set();
		if ($found = array_search($name, static::$cache[static::$model]))
		{
			return $found;
		}

		return static::from('name', array($name));
	}

	/**
	 * Implements dynamic CodeTo_Concrete::to_{key} methods.
	 *
	 * @param	string	$name  The method name
	 * @param	string	$args  The method args
	 * @return	mixed	Based on static::$return_type
	 * @throws	BadMethodCallException
	 */
	public static function __callStatic($name, $args)
	{
		if (strncmp($name, 'to_', 3) === 0)
		{
			return static::to(substr($name, 3), $args);
		}
		elseif (strncmp($name, 'from_', 5) === 0)
		{
			return static::from(substr($name, 5), $args);
		}

		throw new \BadMethodCallException('Method "'.$name.'" does not exist.');
	}

	/**
	 * Get some key's value by code
	 */
	protected static function to($key, $args)
	{
		static::set();
		$code = array_shift($args);
		if ( ! isset(static::$cache[static::$model][$code][$key]))
		{
			return false;
		}

		return static::$cache[static::$model][$code][$key];
	}

	/**
	 * Get code by somekey's value
	 */
	protected static function from($key, $args)
	{
		static::set();
		$arg = array_shift($args);
		foreach (static::$cache[static::$model] as $code => $vals)
		{
			if ( ! is_array($vals)) continue;
			$val = \Arr::get($vals, $key);
			if ($val == $arg)
			{
				return $code;
			}
		}

		return false;
	}
}
