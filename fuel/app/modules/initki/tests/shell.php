<?php
namespace Initki;

class Concrete_Shell_From_Script extends Shell
{
	protected static $script = <<< '__EOL__'
echo -n a $1 $2
__EOL__;
}

class Concrete_Shell_From_File extends Shell
{
	protected static $path = __DIR__;
	protected static $file = 'fixture/shell.sh';
}

class Concrete_Shell_Undefined_Shell extends Shell
{
}

class Concrete_Shell_Not_Exist_File extends Shell
{
	protected static $file = '/n/o/e/x/i/s/ts.sh';
}

/**
 * Shell class Tests
 *
 * @group Modules
 */
class Test_Shell extends \TestCase
{
	public function test_exec_script()
	{
		$expected = 'a';
		$actual = Concrete_Shell_From_Script::exec();
		$this->assertEquals($expected, $actual);

		$expected = 'a b c';
		$actual = Concrete_Shell_From_Script::exec('b', 'c');
		$this->assertEquals($expected, $actual);
	}

	public function test_exec_file()
	{
		$expected = 'x';
		$actual = Concrete_Shell_From_File::exec();
		$this->assertEquals($expected, $actual);

		$expected = 'x y z';
		$actual = Concrete_Shell_From_File::exec('y', 'z');
		$this->assertEquals($expected, $actual);
	}

	public function test_undefined_shell()
	{
		$this->setExpectedException('\RuntimeException');
		Concrete_Shell_Undefined_Shell::exec();
	}

	public function test_not_exist_file()
	{
		$this->setExpectedException('\RuntimeException');
		Concrete_Shell_Not_Exist_File::exec();
	}
}
