<?php
/**
 * DbFixture class for unit testing
 *
 * @package app
 * @subpackage initKi
 * @author Kenji Suzuki
 * @author kawamura.hryk
 * @copyright 2011 Kenji Suzuki
 * @link https://github.com/kenjis
 */

namespace Initki;

class DbFixture
{
	protected static $file_type = 'yaml';
	protected static $file_ext = 'yml';

	public static function load($table, $file, $namespace)
	{
		$fixt_file = static::fixture($file, $namespace);
		if ( ! file_exists($fixt_file))
		{
			die('No such file: '.$fixt_file.PHP_EOL);
		}

		$data = file_get_contents($fixt_file);
		$data = \Format::forge($data, static::$file_type)->to_array();
		\DB::query('SET foreign_key_checks = 0')->execute();
		static::empty_table($table);
		foreach ($data as $row)
		{
			\DB::insert($table)->set($row)->execute();
		}

		\DB::query('SET foreign_key_checks = 1')->execute();
		\Log::info('Table Fixture '.$fixt_file.' loaded', __METHOD__);
		return $data;
	}

	protected static function fixture($file, $namespace)
	{
		$path = APPPATH;
		if ($namespace)
		{
			$path .= 'modules/'.strtolower($namespace);
		}

		$path .= 'tests/fixture/';
		return $path.$file.'_fixt'.'.'.static::$file_ext;
	}

	protected static function empty_table($table)
	{
		if (\DBUtil::table_exists($table))
		{
			\DBUtil::truncate_table($table);
		}
		else
		{
			die('No such table: '.$table.PHP_EOL);
		}
	}
}
