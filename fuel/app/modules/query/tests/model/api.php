<?php
namespace Query;

class Model_Api_Concrete extends Model_Api
{
	protected static $_table_name = 'fugahoge';
	protected static $_properties = array(
		'id', 'column1', 'column2', 'column3', 'column4', 'column5'
		);

	protected static $query = array();

	protected static $query_conditions = array(
		'uses_orm_query' => true,
		'or_where_groups' => array(
			'column1' => 0, 'column2' => 0, // group-0
			'column3' => 1, 'column4' => 1, // group-1
			),
		'period_property' => 'updated_at',
		);

	protected static $base_url = 'http://example.com/';

	/**
	 * A stub method of Api class
	 */
	protected static function api($name, $method = 'get')
	{
		return array(
			array('aaa' => '000', 'bbb' => '111', 'ccc' => '222'),
			3, 4, 5,
			);
	}
}

class Model_Api_Concrete_Empty extends Model_Api_Concrete
{
	protected static function api($name, $method = 'get')
	{
		return null;
	}
}

/**
 * Model Api class Tests
 *
 * @group Modules
 */
class Test_Model_Api extends \TestCase
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
		$actual = Model_Api_Concrete::query_conditions();
		$this->assertEquals($expected, $actual);
	}

	public function test_query()
	{
		$expected = array();
		$actual = Model_Api_Concrete::forge()->query();
		$this->assertEquals($expected, $actual);
	}

	public function test_build_query()
	{
		$expected = array('id' => 77, 'name' => 'sevenseven');
		$params = array('id' => 77, 'name' => 'sevenseven');
		$actual = Model_Api_Concrete::forge()->build_query($params)->query();
		$this->assertEquals($expected, $actual);
	}

	public function test_get()
	{
		$expected = array(
			array('aaa' => '000', 'bbb' => '111', 'ccc' => '222'),
			3, 4, 5,
			);
		$actual = Model_Api_Concrete::forge()->get();
		$this->assertEquals($expected, $actual);
	}

	public function test_get_empty()
	{
		$expected = array();
		$actual = Model_Api_Concrete_Empty::forge()->get();
		$this->assertEquals($expected, $actual);
	}

	public function test_get_one()
	{
		$expected = array('aaa' => '000', 'bbb' => '111', 'ccc' => '222');
		$actual = Model_Api_Concrete::forge()->get_one();
		$this->assertEquals($expected, $actual);
	}

	public function test_get_one_empty()
	{
		$expected = array();
		$actual = Model_Api_Concrete_Empty::forge()->get_one();
		$this->assertEquals($expected, $actual);
	}

	public function test_post()
	{
		$expected = array(
			array('aaa' => '000', 'bbb' => '111', 'ccc' => '222'),
			3, 4, 5,
			);
		$actual = Model_Api_Concrete::forge()->post();
		$this->assertEquals($expected, $actual);
	}

	public function test_post_empty()
	{
		$expected = array();
		$actual = Model_Api_Concrete_Empty::forge()->post();
		$this->assertEquals($expected, $actual);
	}
}
