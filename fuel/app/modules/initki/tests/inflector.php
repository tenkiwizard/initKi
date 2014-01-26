<?php
namespace Initki;

/**
 * Inflector class Tests
 *
 * @group Modules
 */
class Test_Inflector extends \TestCase
{
	public function test_decontroller()
	{
		$expected = 'Fuga_Hoge_Foo_Bar';

		$actual = Inflector::decontroller('Controller_Fuga_Hoge_Foo_Bar');
		$this->assertEquals($expected, $actual);

		$actual = Inflector::decontroller('Fuga_Hoge_Foo_Bar');
		$this->assertEquals($expected, $actual);
	}

	public function test_viewerize()
	{
		$expected = 'fuga/hoge/foo/bar/index';

		$actual = Inflector::viewerize('Controller_Fuga_Hoge_Foo_Bar', 'index');
		$this->assertEquals($expected, $actual);

		$actual = Inflector::viewerize('Fuga_Hoge_Foo_Bar', 'index');
		$this->assertEquals($expected, $actual);
	}
}
