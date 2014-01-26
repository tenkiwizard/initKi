<?php
/**
 * Extended Inflector
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Inflector
{
	/**
	 * 'Controller_Fuga_Hoge' -> 'Fuga_Hoge'
	 *
	 * @param string $class_name
	 * @return string decontrollered class name
	 */
	public static function decontroller($class_name)
	{
		$class_name = \Inflector::denamespace($class_name);
		if (strpos($class_name, 'Controller_') === 0)
		{
			$class_name = substr($class_name, 11);
		}

		return $class_name;
	}

	/**
	 * 'Controller_Fuga_Hoge' -> 'fuga/hoge'
	 *
	 * @param string $class_name
	 * @return string viewerized class name
	 */
	public static function viewerize($class_name, $action = '')
	{
		return strtolower(
			str_replace('_', '/', static::decontroller($class_name)).
			'/'.$action);
	}
}
