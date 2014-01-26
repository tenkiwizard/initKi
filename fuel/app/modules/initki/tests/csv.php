<?php
namespace Initki;

/**
 * Csv class Tests (Including Shift_JIS character set)
 *
 * @group Modules
 */
class Test_Csv extends \TestCase
{
	public function setUp()
	{
		$this->file = APPPATH.'modules/initki/tests/fixture/csv/sjis-crlf.csv';
	}

	public function test_external_encoding()
	{
		$csv = Csv::forge($this->file);
		$expected = 'UTF-8';
		$actual = $csv->external_encoding();
		$this->assertEquals($expected, $actual);

		$expected = 'SJIS-win';
		$actual = $csv->external_encoding('SJIS-win');
		$this->assertEquals($expected, $actual);
	}

	public function test_current_sjis()
	{
		$csv = Csv::forge($this->file);
		$csv->external_encoding('SJIS-win');
		$expected = array(
			'1',
			'きらきら星',
			'icon1.png',
			'com.ssc.SoundGame.kirakira01',
			'06e08a292a8290dfb44c0780eb4650bd.zip',
			'キラキラボシ',
			'キラキラボシ,キラキラボシ,ホシ',
			);
		$actual = $csv->current();
		$this->assertEquals($expected, $actual);
	}

	public function test_current_utf8()
	{
		$file = APPPATH.'/modules/initki/tests/fixture/csv/utf8n-lf.csv';
		$csv = Csv::forge($file);
		$expected = array(
			'1',
			'きらきら星',
			'icon1.png',
			'com.ssc.SoundGame.kirakira01',
			'06e08a292a8290dfb44c0780eb4650bd.zip',
			'キラキラボシ',
			'キラキラボシ,キラキラボシ,ホシ',
			);
		$actual = $csv->current();
		$this->assertEquals($expected, $actual);
	}
}
