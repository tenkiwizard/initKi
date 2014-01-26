<?php
namespace Initki;

/**
 * Datetime class Tests
 *
 * @group Modules
 * @todo 月またぎ、年またぎ等のテストケースが足りないかなあ・・・
 */
class Test_Datetime extends \TestCase
{
	public function test_interval_str()
	{
		$fmt = Datetime::interval_str(array());
		$this->assertEquals($fmt, 'P');

		$fmt = Datetime::interval_str(array('year'=>'1'));
		$this->assertEquals($fmt, 'P1Y');

		$fmt = Datetime::interval_str(array('month'=>'2'));
		$this->assertEquals($fmt, 'P2M');

		$fmt = Datetime::interval_str(array('day'=>'3'));
		$this->assertEquals($fmt, 'P3D');

		$fmt = Datetime::interval_str(array('week'=>'4'));
		$this->assertEquals($fmt, 'P4W');

		$fmt = Datetime::interval_str(array('hour'=>'5'));
		$this->assertEquals($fmt, 'PT5H');

		$fmt = Datetime::interval_str(array('minute'=>'6'));
		$this->assertEquals($fmt, 'PT6M');

		$fmt = Datetime::interval_str(array('second'=>'7'));
		$this->assertEquals($fmt, 'PT7S');

		$list = array(
				'year' => '2',
				'month' => '12',
				'day' => '31',
				'hour' => '23',
				'minute' => '58',
				'second' => '59',
			);
		$fmt = Datetime::interval_str($list);
		$this->assertEquals($fmt, 'P2Y12M31DT23H58M59S');

		$fmt = Datetime::interval_str(array('day' => '', 'week' => ''));
		$this->assertFalse($fmt);

	}

	public function test_format()
	{
		$str = Datetime::format('test');
		$this->assertFalse($str);

		$str = Datetime::format('2013-06-18');
		$this->assertEquals($str, '13/06/18 00:00');

		$str = Datetime::format('2014-07-19 01:01:01', 'Y/m/d-H:i:s');
		$this->assertEquals($str, '2014/07/19-01:01:01');

	}

	public function test_is_valid_date()
	{
		$is_vali = Datetime::is_valid_date('2013-06-18');
		$this->assertTrue($is_vali);

		$is_vali = Datetime::is_valid_date('hogehoge');
		$this->assertFalse($is_vali);
	}

	public function test_diff()
	{
		$to   = '2013-06-13';

		$from = '2013-06-12';
		$diff = Datetime::diff($from, $to);
		$this->assertEquals($diff, -1);

		$from = '2013-06-13';
		$diff = Datetime::diff($from, $to);
		$this->assertEquals($diff, 0);

		$from = '2013-06-14';
		$diff = Datetime::diff($from, $to);
		$this->assertEquals($diff, 1);

		$diff = Datetime::diff('hoge', $to);
		$this->assertFalse($diff);

		$diff = Datetime::diff($from, 'hoge');
		$this->assertFalse($diff);
	}

	public function test_add()
	{
		$add_day = Datetime::add(
				'2013-06-13',
				Datetime::interval_str(array('day' => 1)),
				'Y-m-d');
		$this->assertEquals($add_day, '2013-06-14');
	}

	public function test_sub()
	{
		$sub_day = Datetime::sub(
				'2013-06-13',
				Datetime::interval_str(array('day' => 1)),
				'Y-m-d');
		$this->assertEquals($sub_day, '2013-06-12');
	}

	public function test_dates_between()
	{
		$list = Datetime::dates_between(
				'20130611',
				'20130611');
		$this->assertTrue(count($list) === 1);
		$this->assertEquals($list[0], '20130611');

		$list = Datetime::dates_between(
				'20130611',
				'2013-06-15',
				'Y-m-d');
		$this->assertTrue(count($list) === 5);
		$this->assertEquals($list[0], '2013-06-11');
		$this->assertEquals($list[1], '2013-06-12');
		$this->assertEquals($list[2], '2013-06-13');
		$this->assertEquals($list[3], '2013-06-14');
		$this->assertEquals($list[4], '2013-06-15');

		$list = Datetime::dates_between(
				'2013-06-20',
				'2013-06-16',
				'Y-m-d');
		$this->assertTrue(count($list) === 0);

		$list = Datetime::dates_between(
				'hoge',
				'20130611');
		$this->assertFalse($list);

		$list = Datetime::dates_between(
				'20130611',
				'hoge');
		$this->assertFalse($list);
	}

	public function test_age()
	{
		$expected = 1;
		$actual = Datetime::age('20010102', '20020102');
		$this->assertSame($expected, $actual);

		$expected = 0;
		$actual = Datetime::age('20010102', '20020101');
		$this->assertSame($expected, $actual);

		$nextyear = date('Ymd', strtotime('-1 year'));
		$expected = 1;
		$actual = Datetime::age($nextyear);
		$this->assertSame($expected, $actual);
	}
}
