<?php
namespace Query;

class Model_Db_Concrete extends Model_Db
{
	protected static $_table_name = 'fugahoge';
	protected static $_properties = array(
		'id', 'column1', 'column2', 'column3', 'column4', 'column5'
		);

	protected static $query_conditions = array(
		'uses_orm_query' => true,
		'or_where_groups' => array(
			'column1' => 0, 'column2' => 0, // group-0
			'column3' => 1, 'column4' => 1, // group-1
			),
		'period_property' => 'updated_at',
		);
}

/**
 * Model DB class Tests
 *
 * @group Modules
 */
class Test_Model_Db extends \TestCase
{
	public function test_query_conditions()
	{
		$expected = array(
			'uses_orm_query' => true,
			'or_where_groups' => array(
				'column1' => 0, 'column2' => 0, // group-0
				'column3' => 1, 'column4' => 1, // group-1
				),
			'period_property' => 'updated_at',
			);
		$actual = Model_Db_Concrete::query_conditions();
		$this->assertEquals($expected, $actual);
	}

    /**
     * May be obsolete !?
     */
	public function test_build_query()
	{
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column2` AS `t0_c2`, `t0`.`column3` AS `t0_c3`, `t0`.`column4` AS `t0_c4`, `t0`.`column5` AS `t0_c5` ";
		$expected .= "FROM `fugahoge` AS `t0` LIMIT 1000";
		$actual = (string)Model_Db_Concrete::forge()->build_query()->get_query();
		$this->assertEquals($expected, $actual);

		$params = array(
			'from' => '20150102030405',
			'to'   => '20160607080910',
			'order' => 'column3',
			'direction' => 'desc',
			'limit' => '202',
			'offset' => '101',
			'column1' => 'aaaaa',
		);
		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column2` AS `t0_c2`, `t0`.`column3` AS `t0_c3`, `t0`.`column4` AS `t0_c4`, `t0`.`column5` AS `t0_c5` ";
		$expected .= "FROM `fugahoge` AS `t0` WHERE `t0`.`updated_at` >= '20150102030405' AND `t0`.`updated_at` <= '20160607080910' ORDER BY `t0`.`column3` DESC LIMIT 202 OFFSET 101";
		$actual = (string)Model_Db_Concrete::forge()->build_query($params, true)->get_query();
		$this->assertEquals($expected, $actual);

		$expected = "SELECT `t0`.`id` AS `t0_c0`, `t0`.`column1` AS `t0_c1`, `t0`.`column2` AS `t0_c2`, `t0`.`column3` AS `t0_c3`, `t0`.`column4` AS `t0_c4`, `t0`.`column5` AS `t0_c5` ";
		$expected .= "FROM `fugahoge` AS `t0` WHERE `t0`.`updated_at` >= '20150102030405' AND `t0`.`updated_at` <= '20160607080910' AND (`t0`.`column1` = 'aaaaa') ORDER BY `t0`.`column3` DESC LIMIT 202 OFFSET 101";
		$actual = (string)Model_Db_Concrete::forge()->build_query($params)->get_query();
		$this->assertEquals($expected, $actual);
	}
}
