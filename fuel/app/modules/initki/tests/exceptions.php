<?php
namespace Initki;

class Concrete_Exceptions extends Exceptions
{
	public static function get_module_path()
	{
		return static::module_path();
	}

	public static function get_files()
	{
		return static::files();
	}

	public static function get_class_name($file)
	{
		return static::class_name($file);
	}
}

/**
 * Exceptions class Tests
 *
 * @group Modules
 */
class Test_Exceptions extends \TestCase
{
	public function test_module_path()
	{
		$expected = APPPATH.'modules/exception/classes';
		$actual = Concrete_Exceptions::get_module_path();
		$this->assertEquals($expected, $actual);
	}

	public function test_files()
	{
		$actual = Concrete_Exceptions::get_files();
		$this->assertTrue(is_array($actual));
		$this->assertFalse(empty($actual));
	}

	public function test_class_name()
	{
		$expected = 'someexception';
		$actual = Concrete_Exceptions::get_class_name('someexception.php');
		$this->assertEquals($expected, $actual);

		$expected = 'anyexception.rb';
		$actual = Concrete_Exceptions::get_class_name('anyexception.rb');
		$this->assertEquals($expected, $actual);
	}

	public function test_register()
	{
		// This test is OK unless some Exception is not thrown
		Exceptions::register();
	}
}
