<?php
namespace Initki;

/**
 * Api class Tests
 *
 * @group Modules
 */
class Test_Api extends \TestCase
{
	public function test_base_url()
	{
		\Config::load('resource', true);
		$expected = \Config::get('resource.api.base_url');
		$actual = Api::base_url();
		$this->assertSame($expected, $actual);

		$base_url = 'http://example.com/api/v100/';
		$expected = $base_url;
		$actual = Api::base_url($base_url);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @depends test_base_url
	 */
	public function test_url()
	{
		$expected = Api::base_url().'item/name/99';
		$actual = Api::url('item_name_99');
		$this->assertEquals($expected, $actual);
	}

	public function test_set_static_property()
	{
		$expected = 'get';
		$actual = Api::method();
		$this->assertEquals($expected, $actual);

		$expected = 'post';
		$actual = Api::method('post');
		$this->assertEquals($expected, $actual);

		$this->assertTrue(Api::auto_format());

		$this->assertFalse(Api::auto_format(false));
	}

	public function test_callStatic()
	{
		$stub = $this->getMock('Initki\Api', array('http'));
		$stub::staticExpects($this->at(0)) // at()の使い方がいまいちわかってない、多分間違ってる
			->method('http')
			->will($this->returnArgument(0));
		$base_url = 'http://example.com/api/v2/';
		Api::base_url($base_url);
		$expected = $base_url.'fuga/hoge';
		$actual = $stub::fuga_hoge();
		$this->assertEquals($expected, $actual);

		$stub = $this->getMock('Initki\Api', array('http'));
		$stub::staticExpects($this->at(0)) // でも期待値が返るのでこうしておく
			->method('http')
			->will($this->returnArgument(1));
		Api::base_url($base_url);
		$expected = array('id' => 99, 'name' => 'foobar');
		$actual = $stub::fuga_hoge(array('id' => 99, 'name' => 'foobar'));
		$this->assertEquals($expected, $actual);
	}
}
