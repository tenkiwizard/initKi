<?php
namespace Query;

class Model_Builder_Db extends Model_Db
{
	protected static $_table_name = 'fugahoge';
	protected static $_properties = array(
		'id', 'column1', 'column2', 'column3', 'column4', 'column5'
		);
	protected static $max_limit = 1000;
	protected static $query_conditions = array(
		'uses_orm_query' => true,
		'period_property' => 'updated_at',
		'or_where_groups' => array(
			'column1' => 0, 'column2' => 0, // group-0
			'column3' => 1, 'column4' => 1, // group-1
			),
		);
}

class Model_Builder_Db_NoOrm extends Model_Builder_Db
{
	protected static $query_conditions = array(
		'uses_orm_query' => false, // The case NOT use \Model\Orm
		'period_property' => 'updated_at',
		'or_where_groups' => array(
			'column1' => 0, 'column2' => 0, // group-0
			'column3' => 1, 'column4' => 1, // group-1
			),
		);
}

/**
 * Builder_Db class Tests
 *
 * @group Modules
 */

class Test_Builder_Db extends \TestCase
{
	public function test_get()
	{
		$this->setExpectedException('BadMethodCallException');
		Builder_Db::forge(new Model_Builder_Db)->get();
	}

	/**
	 * @todo Implement
	 */
	public function test_get_no_orm()
	{
		$this->markTestIncomplete();
	}

	public function test_select()
	{
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column2` AS `t0_c2`, `t0`.`column3` AS `t0_c3`, `t0`.`column4` AS `t0_c4`, `t0`.`column5` AS `t0_c5` FROM `fugahoge` AS `t0`";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select();
		$this->assertEquals($expected, $actual);

		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1` FROM `fugahoge` AS `t0`";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id', 'column1'));
		$this->assertEquals($expected, $actual);
	}

	public function test_select_no_orm()
	{
		$expected = "SELECT * FROM `fugahoge`";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select();
		$this->assertEquals($expected, $actual);

		$params = array('id', 'column1');
		$expected = "SELECT `id`, `column1` FROM `fugahoge`";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_where()
	{
		// WHERE a=1
		$params = array('id' => '1');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE `t0`.`id` = '1'";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);

		// WHERE (a=1 OR a=2) AND (b=3 OR b=4)
		$params = array('id' => '1,a', 'column5' => '2,b');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE (`t0`.`id` = '1' OR `t0`.`id` = 'a') AND (`t0`.`column5` = '2' OR `t0`.`column5` = 'b')";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);

		// WHERE a=1 AND b=2
		$params = array('id' => 'zzz', 'column5' => 'yyy');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE `t0`.`id` = 'zzz' AND `t0`.`column5` = 'yyy'";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);

		// WHERE (a=1 OR b=2) AND (c=3 OR d=4)
		$params = array(
			'column1' => 'abc', 'column2' => 'xyz',
			'column3' => '123', 'column4' => '987',
			);
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE (`t0`.`column1` = 'abc' OR `t0`.`column2` = 'xyz') AND (`t0`.`column3` = '123' OR `t0`.`column4` = '987')";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_where_no_orm()
	{
		// WHERE a=1
		$params = array('id' => '1');
		$expected = "SELECT `id` FROM `fugahoge` WHERE `id` = '1'";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);

		// WHERE (a=1 OR a=2) AND (b=3 OR b=4)
		$params = array('id' => '1,a', 'column5' => '2,b');
		$expected = "SELECT `id` FROM `fugahoge` WHERE (`id` = '1' OR `id` = 'a') AND (`column5` = '2' OR `column5` = 'b')";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);

		// WHERE a=1 AND b=2
		$params = array('id' => 'zzz', 'column5' => 'yyy');
		$expected = "SELECT `id` FROM `fugahoge` WHERE `id` = 'zzz' AND `column5` = 'yyy'";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);

		// WHERE (a=1 OR b=2) AND (c=3 OR d=4)
		$params = array(
			'column1' => 'abc', 'column2' => 'xyz',
			'column3' => '123', 'column4' => '987',
			);
		$expected = "SELECT `id` FROM `fugahoge` WHERE (`column1` = 'abc' OR `column2` = 'xyz') AND (`column3` = '123' OR `column4` = '987')";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->where($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_period_conditions()
	{
		// period from
		$params = array('from' => '2013-01-02 03:04:05');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE `t0`.`updated_at` >= '2013-01-02 03:04:05' ORDER BY `t0`.`id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
		// period to
		$params = array('to' => '2014-06-07 08:09:10');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE `t0`.`updated_at` <= '2014-06-07 08:09:10' ORDER BY `t0`.`id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
		// preod both from and to
		$params = array('from' => '2013-01-02 03:04:05', 'to' => '2014-06-07 08:09:10');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` WHERE `t0`.`updated_at` >= '2013-01-02 03:04:05' AND `t0`.`updated_at` <= '2014-06-07 08:09:10' ORDER BY `t0`.`id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_period_conditions_no_orm()
	{
		// period from
		$params = array('from' => '2013-01-02 03:04:05');
		$expected = "SELECT `id` FROM `fugahoge` WHERE `updated_at` >= '2013-01-02 03:04:05' ORDER BY `id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
		// period to
		$params = array('to' => '2014-06-07 08:09:10');
		$expected = "SELECT `id` FROM `fugahoge` WHERE `updated_at` <= '2014-06-07 08:09:10' ORDER BY `id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
		// preod both from and to
		$params = array('from' => '2013-01-02 03:04:05', 'to' => '2014-06-07 08:09:10');
		$expected = "SELECT `id` FROM `fugahoge` WHERE `updated_at` >= '2013-01-02 03:04:05' AND `updated_at` <= '2014-06-07 08:09:10' ORDER BY `id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_order_conditions()
	{
		// order asc (default)
		$params = array('order' => 'column1');
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column5` AS `t0_c2` FROM `fugahoge` AS `t0` ORDER BY `t0`.`column1` ASC, `t0`.`id` ASC, `t0`.`column5` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id', 'column1', 'column5'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// order asc (specified)
		$params = array('order' => 'column2', 'direction' => 'asc');
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column5` AS `t0_c2` FROM `fugahoge` AS `t0` ORDER BY `t0`.`column2` ASC, `t0`.`id` ASC, `t0`.`column1` ASC, `t0`.`column5` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id', 'column1', 'column5'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// order desc
		$params = array('order' => 'column3', 'direction' => 'desc');
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column5` AS `t0_c1`, `t0`.`column1` AS `t0_c2` FROM `fugahoge` AS `t0` ORDER BY `t0`.`column3` DESC, `t0`.`id` ASC, `t0`.`column5` ASC, `t0`.`column1` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id', 'column5', 'column1'))->conditions($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_order_conditions_no_orm()
	{
		// order asc (default)
		$params = array('order' => 'column1');
		$expected = "SELECT `id`, `column1`, `column5` FROM `fugahoge` ORDER BY `column1` ASC, `id` ASC, `column5` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id', 'column1', 'column5'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// order asc (specified)
		$params = array('order' => 'column2', 'direction' => 'asc');
		$expected = "SELECT `id`, `column1`, `column5` FROM `fugahoge` ORDER BY `column2` ASC, `id` ASC, `column1` ASC, `column5` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id', 'column1', 'column5'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// order desc
		$params = array('order' => 'column3', 'direction' => 'desc');
		$expected = "SELECT `id`, `column5`, `column1` FROM `fugahoge` ORDER BY `column3` DESC, `id` ASC, `column5` ASC, `column1` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id', 'column5', 'column1'))->conditions($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_limit_conditions()
	{
		$params = array('limit' => '999');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` ORDER BY `t0`.`id` ASC LIMIT 999";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// over max_limit
		$params = array('limit' => '1001');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` ORDER BY `t0`.`id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// with offset
		$params = array('limit' => '20', 'offset' => '10');
		$expected = "SELECT `t0`.`id` AS `t0_c0` FROM `fugahoge` AS `t0` ORDER BY `t0`.`id` ASC LIMIT 20 OFFSET 10";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_limit_conditions_no_orm()
	{
		$params = array('limit' => '999');
		$expected = "SELECT `id` FROM `fugahoge` ORDER BY `id` ASC LIMIT 999";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// over max_limit
		$params = array('limit' => '1001');
		$expected = "SELECT `id` FROM `fugahoge` ORDER BY `id` ASC LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);

		// with offset
		$params = array('limit' => '20', 'offset' => '10');
		$expected = "SELECT `id` FROM `fugahoge` ORDER BY `id` ASC LIMIT 20 OFFSET 10";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->select(array('id'))->conditions($params);
		$this->assertEquals($expected, $actual);
	}

	public function test_build()
	{
		$params = array(
			'from' => '20150102030405',
			'to'   => '20160607080910',
			'order' => 'column3',
			'direction' => 'desc',
			'limit' => '202',
			'offset' => '101',
			'column1' => 'aaaaa',
			);
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column2` AS `t0_c2`, `t0`.`column3` AS `t0_c3`, `t0`.`column4` AS `t0_c4`, `t0`.`column5` AS `t0_c5` FROM `fugahoge` AS `t0` ";
		$expected .= "WHERE `t0`.`updated_at` >= '20150102030405' AND `t0`.`updated_at` <= '20160607080910' AND (`t0`.`column1` = 'aaaaa') ORDER BY `t0`.`column3` DESC LIMIT 202 OFFSET 101";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->build($params)->get_query();
		$this->assertEquals($expected, $actual);

		// Along the way, if init() is working
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column2` AS `t0_c2`, `t0`.`column3` AS `t0_c3`, `t0`.`column4` AS `t0_c4`, `t0`.`column5` AS `t0_c5` FROM `fugahoge` AS `t0` LIMIT 1000";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db)->build()->get_query();
		$this->assertEquals($expected, $actual);
	}

	public function test_build_no_orm()
	{
		$params = array(
			'from' => '20150102030405',
			'to'   => '20160607080910',
			'order' => 'column3',
			'direction' => 'desc',
			'limit' => '202',
			'offset' => '101',
			'column1' => 'aaaaa',
			);
		$expected = "SELECT * FROM `fugahoge` ";
		$expected .= "WHERE `updated_at` >= '20150102030405' AND `updated_at` <= '20160607080910' AND (`column1` = 'aaaaa') ORDER BY `column3` DESC LIMIT 202 OFFSET 101";
		$actual = (string)Builder_Db::forge(new Model_Builder_Db_NoOrm)->build($params);
		$this->assertEquals($expected, $actual);
	}
}
