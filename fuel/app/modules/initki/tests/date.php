<?php
namespace Initki;

/**
 * Date class Tests
 *
 * @group Modules
 */
class Test_Date extends \TestCase
{
	public function test_add_valid()
	{
		$date =  Date::create_from_string('2013-01-30 23:59:58' , 'mysql');
		$expected = '2013-01-30 23:59:59';
		$actual = $date->add(1)->format('mysql');
		$this->assertEquals($expected, $actual);

		$expected = '2013-01-31 00:00:00';
		$actual = $date->add(1)->format('mysql');
		$this->assertEquals($expected, $actual);

		$expected = '2013-02-01 00:00:00';
		$actual = $date->add(60 * 60 * 24)->format('mysql');
		$this->assertEquals($expected, $actual);
	}

	public function test_add_invalid()
	{
		$date =  Date::create_from_string('2013-01-30 23:59:58' , 'mysql');
		try
		{
			$date->add('hoge')->format('mysql');
			$this->assertTrue(false);
		}
		catch (\UnexpectedValueException $e)
		{
			$this->assertTrue(true);
		}

		try
		{
			$date->add('1')->format('mysql');
			$this->assertTrue(false);
		}
		catch (\UnexpectedValueException $e)
		{
			$this->assertTrue(true);
		}

	}

}
