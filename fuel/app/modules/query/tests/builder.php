<?php
namespace Query;

class Builder_Concrete extends Builder
{
	public function select(array $select = null) {}

	public function __get($property)
	{
		return $this->{$property};
	}
}

class Model_Builder extends Model
{
	protected static $_table_name = 'fugahoge';
	protected static $_properties = array('id', 'column1', 'column2');
	protected static $query_conditions = array(
		'max_limit' => 999,
		'selects' => array('id', 'column1'),
	);
	public function build_query() {}
}

/**
 * Builder class Tests
 *
 * @group Modules
 */

class Test_Builder extends \TestCase
{
	public function test_forge()
	{
		$builder = Builder_Concrete::forge(new Model_Builder);
		$expected = 999;
		$actual = $builder->max_limit;
		$this->assertSame($expected, $actual);

		$expected = array('id', 'column1');
		$actual = $builder->selects;
		$this->assertEquals($expected, $actual);
	}

	public function test_has_property()
	{
		Builder_Concrete::forge(new Model_Builder);
		$this->assertTrue(Builder_Concrete::_validation_has('column2'));
		$this->assertTrue(Builder_Concrete::_validation_has('fugahoge.column2'));
		$this->assertFalse(Builder_Concrete::_validation_has('column3'));
		$this->assertFalse(Builder_Concrete::_validation_has('fugahoge.column3'));
	}

	public function test_validation_has()
	{
		Builder_Concrete::forge(new Model_Builder);
		$this->assertTrue(Builder_Concrete::_validation_has(''));
		$this->assertTrue(Builder_Concrete::_validation_has('column1'));
		$this->assertFalse(Builder_Concrete::_validation_has('unknown'));
	}

	public function test_is_validate_initial()
	{
		$builder = Builder_Concrete::forge(new Model_Builder);
		$this->assertFalse($builder->is_valid());
	}
	
	/**
	 * @dataProvider valid_params_provider
	 */
	public function test_is_validate_ok($params)
	{
		$builder = Builder_Concrete::forge(new Model_Builder);
		$this->assertTrue($builder->validate($params)->is_valid());
	}

	public function valid_params_provider()
	{
		return array(
			array(array('limit' => '20')),
			array(array('offset' => '10')),
			array(array('order' => 'column2')),
			array(array('direction' => 'asc')),
			array(array('direction' => 'desc')),
			array(array('from' => '20130102')),
			array(array('to' => '20130304')),
			);
	}

	/**
	 * @dataProvider invalid_params_provider
	 */
	public function test_is_validate_ng($params)
	{
		$builder = Builder_Concrete::forge(new Model_Builder());
		$this->setExpectedException('HttpInvalidParameterException');
		$builder->validate($params)->is_valid();
	}

	public function invalid_params_provider()
	{
		return array(
			array(array('limit' => 'a')),
			array(array('offset' => 'b')),
			array(array('order' => 'column999')),
			array(array('direction' => 'asc_and_desc')),
			array(array('from' => 'd')),
			array(array('to' => 'e')),
			);
	}

	public function test_query()
	{
		$this->assertNull(Builder_Concrete::query());
	}
}
