<?php
namespace Initki;

/**
 * ValidationRules class Tests
 *
 * @group Modules
 */
class Test_ValidationRules extends \TestCase
{
	public function test_validation_no_tab_and_newline_valid()
	{
		$input = 'タブも改行も含まない文字列です。';
		$actual = ValidationRules::_validation_no_tab_and_newline($input);
		$this->assertTrue($actual);
	}

	/**
	 * @dataProvider includeing_control_char_string_provider
	 */
	public function test_validation_no_tab_and_newline_invalid($input)
	{
		$actual = ValidationRules::_validation_no_tab_and_newline($input);
		$this->assertFalse($actual);
	}

	public function includeing_control_char_string_provider()
	{
		return array(
			array("改行を含む\n 文字列です。"),
			array("改行を含む\r 文字列です"),
			array("改行を含む\r\n 文字列です。"),
			array("タブを含む\t 文字列です。"),
			array("改行と\r タブを含む\t 文字列\n です。"),
			);
	}

	/**
	 * @dataProvider numeric_provider
	 */
	public function test_validation_numeric_valid($input)
	{
		$actual = ValidationRules::_validation_numeric($input);
		$this->assertTrue($actual);
	}

	public function numeric_provider()
	{
		return array(
			// 入力値なので全て文字列で来るであろう？
			array(''),
			array('0'),
			array('1337'),
			array('0x539'),
			array('02471'),
			array('1337e0'),
			array('9.1'),
			array('-1'),
			);
	}

	/**
	 * @dataProvider not_numeric_provider
	 */
	public function test_validation_numeric_invalid($input)
	{
		$actual = ValidationRules::_validation_numeric($input);
		$this->assertFalse($actual);
	}

	public function not_numeric_provider()
	{
		return array(
			array('a'),
			);
	}

	public function test_validation_in()
	{
		$actual = ValidationRules::_validation_in('1', '1:2:3');
		$this->assertTrue($actual);
		$actual = ValidationRules::_validation_in('a', '1:2:3');
		$this->assertFalse($actual);
	}

	public function test_validation_fullwidth_katakana()
	{
		$value = 'イニットケーアィ';
		$actual = ValidationRules::_validation_fullwidth_katakana($value);
		$this->assertTrue($actual);

		$value = 'イニットケーアｲ';
		$actual = ValidationRules::_validation_fullwidth_katakana($value);
		$this->assertFalse($actual);
	}

	public function test_validation_ascii()
	{
		$value = "\x19";
		$actual = ValidationRules::_validation_ascii($value);
		$this->assertFalse($actual);

		$value = "\x20";
		$actual = ValidationRules::_validation_ascii($value);
		$this->assertTrue($actual);

		$value = "\x7f";
		$actual = ValidationRules::_validation_ascii($value);
		$this->assertTrue($actual);

		$value = "\x80";
		$actual = ValidationRules::_validation_ascii($value);
		$this->assertFalse($actual);

		$value = ' aZ_!@#$%^&*()_+|~{}:"?><[];\',./-=\`';
		$actual = ValidationRules::_validation_ascii($value);
		$this->assertTrue($actual);

		$value = 'ｧ';
		$actual = ValidationRules::_validation_ascii($value);
		$this->assertFalse($actual);
	}

	public function test_validation_jp_postal()
	{
		$value = 'o12-3456';
		$actual = ValidationRules::_validation_jp_postal($value);
		$this->assertFalse($actual);

		$value = '12-3456';
		$actual = ValidationRules::_validation_jp_postal($value);
		$this->assertFalse($actual);

		$value = '123-456';
		$actual = ValidationRules::_validation_jp_postal($value);
		$this->assertFalse($actual);

		$value = '123-4567';
		$actual = ValidationRules::_validation_jp_postal($value);
		$this->assertTrue($actual);
	}

	public function test_validation_telno()
	{
		$value = '12345';
		$actual = ValidationRules::_validation_telno($value);
		$this->assertFalse($actual);

		$value = '1-2345';
		$actual = ValidationRules::_validation_telno($value);
		$this->assertFalse($actual);

		$value = '1-2-345o';
		$actual = ValidationRules::_validation_telno($value);
		$this->assertFalse($actual);

		$value = '1-2-3456';
		$actual = ValidationRules::_validation_telno($value);
		$this->assertTrue($actual);

		$value = '1(2)3456';
		$actual = ValidationRules::_validation_telno($value);
		$this->assertFalse($actual);
	}

	public function test_validation_valid_email()
	{
		$value = 'detrame';
		$actual = ValidationRules::_validation_valid_email($value);
		$this->assertFalse($actual);

		$value = 'det@rame.';
		$actual = ValidationRules::_validation_valid_email($value);
		$this->assertFalse($actual);

		$value = '...det...@ra.me';
		$actual = ValidationRules::_validation_valid_email($value);
		$this->assertTrue($actual);

		$value = '...det...@ra.m.e.a.b.c';
		$actual = ValidationRules::_validation_valid_email($value);
		$this->assertTrue($actual);
	}
}
