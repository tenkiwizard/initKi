<?php
namespace Zenkins;

class Concrete_Listener_Gitlab extends Listener_Gitlab
{
	public static $data = array(
		'object_kind' => 'issues',
		'object_attributes' => array(
			array(
				'id' => 101,
				'name' => 'fuga',
				),
			array(
				'id' => 102,
				'name' => 'hoge',
				),
			));

	protected function things()
	{
		return static::$data;
	}
}

class Concrete_Listener_Gitlab_Nulldata extends Concrete_Listener_Gitlab
{
    public static $data = null;
}

/**
 * Listener_Gitlab class Tests
 *
 * @group Modules
 */

class Test_Listener_Gitlab extends \TestCase
{
	public function test_toString()
	{
		$expected = json_encode(Concrete_Listener_Gitlab::$data);
		$actual = (string) Concrete_Listener_Gitlab::forge();
		$this->assertEquals($expected, $actual);
	}

	public function test_listen()
	{
		$expected = Concrete_Listener_Gitlab::$data;
		$actual = Concrete_Listener_Gitlab::forge()->listen();
		$this->assertEquals($expected, $actual);
	}

	public function test_listen_a_field_is_string()
	{
		$expected = Concrete_Listener_Gitlab::$data['object_kind'];
		$actual = Concrete_Listener_Gitlab::forge()->listen('object_kind');
		$this->assertEquals($expected, $actual);
	}

	public function test_listen_a_field_is_array()
	{
		$expected = Concrete_Listener_Gitlab::$data['object_attributes'];
		$actual = Concrete_Listener_Gitlab::forge()->listen('object_attributes');
		$this->assertEquals($expected, $actual);
	}

	public function test_listen_not_exist_field()
	{
		$actual = Concrete_Listener_Gitlab::forge()->listen('fugahoge');
		$this->assertNull($actual);
	}

	public function test_listen_nulldata()
	{
		$actual = Concrete_Listener_Gitlab_Nulldata::forge()->listen('object_attributes');
		$this->assertNull($actual);
	}
}
