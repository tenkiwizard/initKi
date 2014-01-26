<?php
namespace Initki;

class Model_Liquor extends \Query\Model_Db
{
	protected static $_properties = array('id', 'name', 'proof');
	protected static $query_conditions = array(
		'uses_orm_query' => true,
		'or_where_groups' => array(),
		'period_property' => 'updated_at',
		'max_limit' => 0,
		'selects' => array(),
		'wheres' => array(),
		'or_wheres' => array(),
		);
}

class Model_Food extends \Query\Model_Db
{
	protected static $_properties = array('id', 'name', 'calorie');
	protected static $query_conditions = array(
		'uses_orm_query' => true,
		'or_where_groups' => array(),
		'period_property' => 'updated_at',
		'max_limit' => 10,
		'selects' => array(),
		'wheres' => array(),
		'or_wheres' => array(),
		);
}

/**
 * Listview class Tests
 *
 * @group Modules
 */
class Test_Listview extends \TestCase
{
	public function test_forge()
	{
		$liquors = Listview::forge('Initki\Model_Liquor');
		$this->assertTrue($liquors instanceof Listview);
		$this->assertTrue($liquors::model() instanceof Model_Liquor);

		$food = Listview::forge(new Model_Food);
		$this->assertTrue($food instanceof Listview);
		$this->assertTrue($food::model() instanceof Model_Food);
	}

	public function test_query()
	{
		$liquors = Listview::forge('Initki\Model_Liquor');
		$this->assertSame(array(), $liquors->query());

		$query = array('id' => 555, 'name' => 'beer');
		$actual = $liquors->query($query)->query();
		$this->assertSame($query, $actual);

		$actual = $liquors->query(array('proof' => 11))->query();
		$query['proof'] = 11;
		$this->assertSame($query, $actual);

		$actual = $liquors->query(array('price' => '\350'))->query();
		$query['price'] = '\350';
		$this->assertSame($query, $actual);
	}

	public function test_create()
	{
		$this->markTestIncomplete();
	}

	public function test_limit()
	{
		$listview = Listview::forge('Initki\Model_Liquor');
		$this->assertEquals(20, $listview->limit());

		$listview->limit(100);
		$this->assertEquals(100, $listview->limit());
	}
}
