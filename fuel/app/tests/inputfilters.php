<?php
/**
 * InputFilters class Tests
 *
 * @group App
 */
class Test_InputFilters extends TestCase
{
	public function test_check_encoding_invalid_sjis()
	{
		$this->setExpectedException(
			'\HttpInvalidInputException', 'Invalid input data'
			);

		$input = mb_convert_encoding('SJIS の文字列です。', 'SJIS');
		InputFilters::check_encoding($input);
	}

	public function test_check_encoding_valid()
	{
		$input = '正常なUTF-8 の文字列です。';
		$test = InputFilters::check_encoding($input);
		$expected = $input;

		$this->assertEquals($expected, $test);
	}

	/**
	 * @dataProvider newline_provider
	 */
	public function test_check_control_改行とタブを含む文字列($data)
	{
		$input = $data;
		$test = InputFilters::check_control($input);
		$expected = $input;
		$this->assertEquals($expected, $test);
	}

	public function newline_provider()
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
	 * @dataProvider control_code_provider
	 */
	public function test_check_control_制御文字を含む文字列($data)
	{
		$this->setExpectedException(
			'\HttpInvalidInputException', 'Invalid input data'
			);
		$input = $data;
		InputFilters::check_control($input);
	}

	public function control_code_provider()
	{
		return array(
			array("NULL 文字を含む文字列です。\0"),
			array("NULL 文字と改行コードを含む文字列です。\0\n"),
			);
	}
}
