<?php
/**
 * Exceptions class
 *
 * Register my exceptions into autoloader
 *
 * @package  app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Exceptions
{
	const PATH = 'exception/classes';
	const FILE_PATTERN = '\.php$';

	public static function register()
	{
		foreach (static::files() as $file)
		{
			\Autoloader::add_class(
				static::class_name($file), static::module_path().DS.$file);
		}
	}

	protected static function module_path()
	{
		$module_path = \Config::get('module_paths');
		if (is_array($module_path) and ! empty($module_path))
		{
			return array_shift($module_path).self::PATH;
		}

		return null;
	}

	protected static function files()
	{
		return \File::read_dir(
			static::module_path(), 1, array(self::FILE_PATTERN => 'file'));
	}

	protected static function class_name($file)
	{
		return preg_replace('/'.self::FILE_PATTERN.'/', '', $file);
	}
}
