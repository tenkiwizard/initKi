<?php
namespace Initki;

/**
 * Csv Iterator class Tests
 *
 * @group Modules
 */
class Test_Csv_Iterator extends \TestCase
{
	public function setUp()
	{
		$this->file = APPPATH.'modules/initki/tests/fixture/csv/utf8n-lf.csv';
	}

	public function test_forge_ng()
	{
		$this->setExpectedException('Initki\CsvFileAccessException');
		Csv_Iterator::forge('notexists.csv');
	}

	public function test_forge()
	{
		$csv = Csv_Iterator::forge($this->file);
		$this->assertTrue($csv instanceof Csv_Iterator);
	}

	public function test_current()
	{
		$expected = array(
			'1',
			'きらきら星',
			'icon1.png',
			'com.ssc.SoundGame.kirakira01',
			'06e08a292a8290dfb44c0780eb4650bd.zip',
			'キラキラボシ',
			'キラキラボシ,キラキラボシ,ホシ',
			);
		$csv = Csv_Iterator::forge($this->file);
		$actual = $csv->current();
		$this->assertEquals($expected, $actual);

		$expected = array(
			'2',
			'きらきら星2',
			'icon2.png',
			'com.ssc.SoundGame.kirakira02',
			'2efacc4df2915dc382f955ba71bc7adc.zip',
			'キラキラボシ2',
			'キラキラボシ2,キラキラボシ2',
			);
		$actual = $csv->current();
		$this->assertEquals($expected, $actual);
	}

	public function test_key()
	{
		$expected = 0;
		$csv = Csv_Iterator::forge($this->file);
		$actual = $csv->key();
		$this->assertSame($expected, $actual);

		$expected = 1;
		$csv->current();
		$actual = $csv->key();
		$this->assertSame($expected, $actual);
	}

	public function test_next()
	{
		$csv = Csv_Iterator::forge($this->file);
		$csv->current();
		$csv->current();
		$csv->current();
		$this->assertTrue($csv->next());
		$csv->current();
		$this->assertFalse($csv->next());
	}

	public function test_valid()
	{
		$csv = Csv_Iterator::forge($this->file);
		$csv->current();
		$csv->current();
		$csv->current();
		$this->assertTrue($csv->valid());
		$csv->current();
		$this->assertFalse($csv->valid());
	}

	public function test_rewind()
	{
		$csv = Csv_Iterator::forge($this->file);
		$csv->current();
		$csv->current();
		$csv->current();
		$expected = 3;
		$this->assertSame($expected, $csv->key());

		$csv->rewind();
		$expected = 0;
		$this->assertSame($expected, $csv->key());
	}
}
