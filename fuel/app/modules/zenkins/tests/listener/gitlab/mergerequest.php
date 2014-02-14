<?php
namespace Zenkins;

class Listener_Gitlab_Mr extends Listener_Gitlab_Mergerequest
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

class Listener_Gitlab_Mr_Nulldata extends Listener_Gitlab_Mr
{
    public static $data = null;
}

/**
 * Listener_Gitlab_Mergerequest class Tests
 *
 * @group Modules
 */

class Test_Foo extends \TestCase
{
	public function test_listen()
	{
		$expected = Listener_Gitlab_Mr::$data['object_attributes'];
		$actual = Listener_Gitlab_Mr::forge()->listen();
		$this->assertEquals($expected, $actual);
	}

	public function test_listen_nulldata()
	{
		$actual = Listener_Gitlab_Mr_Nulldata::forge()->listen();
		$this->assertNull($actual);
	}
}
