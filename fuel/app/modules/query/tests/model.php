<?php
namespace Query;

class Model_Model extends Model
{
	public function build_query() {}
	//public static function get() {}
}

class Model_Model_HasProperties extends Model_Model
{
	protected static $_table_name = 'fugahoge';
	protected static $_properties = array('id', 'column1', 'column2');
}

/**
 * Model class Tests
 *
 * @group Modules
 */
class Test_Model extends \TestCase
{
	public function test_table_not_set()
	{
		$expected = 'models';
		$actual = Model_Model::table();
		$this->assertEquals($expected, $actual);
	}

	public function test_table()
	{
		$expected = 'fugahoge';
		$actual = Model_Model_HasProperties::table();
		$this->assertEquals($expected, $actual);
	}

	public function test_properties_not_set()
	{
		$this->setExpectedException('FuelException');
		Model_Model::properties();
	}

	public function test_properties()
	{
		$expected = array(
			'id' => array(),
			'column1' => array(),
			'column2' => array(),
			);
		$actual = Model_Model_HasProperties::properties();
		$this->assertEquals($expected, $actual);
	}

	public function test_query_conditions()
	{
		$expected = array(
			'uses_orm_query' => true,
			'or_where_groups' => array(),
			'period_property' => 'updated_at',
			'max_limit' => 1000,
			'selects' => array(),
			'wheres' => array(),
			'or_wheres' => array(),
			);
		$actual = Model_Model::query_conditions();
		$this->assertEquals($expected, $actual);
	}
}
