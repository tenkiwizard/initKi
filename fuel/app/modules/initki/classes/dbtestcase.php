<?php
/**
 * TestCase abstract class extended for Database usable
 *
 * @package app
 * @subpackage initKi
 * @author Kenji Suzuki
 * @author kawamura.hryk
 * @copyright 2011 Kenji Suzuki
 * @link https://github.com/kenjis
 */

namespace Initki;

abstract class DbTestCase extends \TestCase
{
	protected $tables = array(
		// 'table_name' => 'yaml_file_name',
		);

	protected function setUp()
	{
		parent::setUp();
		if ( ! empty($this->tables))
		{
			$this->dbfixt($this->tables);
		}
	}

	protected function dbfixt($tables)
	{
		$tables = is_string($tables) ? func_get_args() : $tables;
		foreach ($tables as $table => $file)
		{
			$fixt_name = $file.'_fixt';
			$namespace = \Inflector::get_namespace(get_class($this));
			$namespace = str_replace('\\', '/', $namespace);
			$this->{$fixt_name} =
				DbFixture::load($table, $file, $namespace);
		}
	}
}
