<?php
namespace Initki;

/**
 * Arr class Tests
 *
 * @group Modules
 */
class Test_Arr extends \TestCase
{
	public function test_change_key_case_tolower()
	{
		$source = array(
			'ABC123' => array('DEF456' => 'GHI'),
			'JKL789' => 'MNO',
			);
		$expected = array(
			'abc123' => array('def456' => 'GHI'),
			'jkl789' => 'MNO',
			);
		$actual = Arr::change_key_case($source); // 2nd. arg default is to lower
		$this->assertEquals($expected, $actual);

		$actual = Arr::change_key_case($source, CASE_LOWER);
		$this->assertEquals($expected, $actual);

		$actual = Arr::change_key_case($source, 'fugahoge'); // Force default 2nd arg
		$this->assertEquals($expected, $actual);
	}

	public function test_change_key_case_toupper()
	{
		$source = array(
			'abc123' => array('def456' => 'ghi'),
			'jkl789' => 'mno',
			);
		$expected = array(
			'ABC123' => array('DEF456' => 'ghi'),
			'JKL789' => 'mno',
			);
		$actual = Arr::change_key_case($source, CASE_UPPER);
		$this->assertEquals($expected, $actual);
	}
}
