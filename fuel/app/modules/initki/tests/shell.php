<?php
namespace Initki;

class Concrete_Shell extends Shell
{
	protected static $script = <<< '__EOL__'
echo -n a $1 $2
__EOL__;
}

/**
 * Shell class Tests
 *
 * @group Modules
 */
class Test_Shell extends \TestCase
{
	public function test_exec()
	{
		$expected = 'a';
		$actual = Concrete_Shell::exec();
		$this->assertEquals($expected, $actual);

		$expected = 'a b c';
		$actual = Concrete_Shell::exec('b', 'c');
		$this->assertEquals($expected, $actual);
	}
}
