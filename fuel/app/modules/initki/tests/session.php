<?php

/**
 * Session class Tests
 *
 * @group Modules
 */

namespace Initki;

class Test_Session extends \TestCase
{
	public function test_name()
	{
		$this->assertEquals(
			'cookie_name_of_file',
			Session::name()
			);
	}

	public function test_encoded()
	{
		$expected = \Crypt::encode(Session::serialize(array(\Session::key())));
		$actual = Session::encoded();
		$this->assertEquals($expected, $actual);
	}

	public function test_back_url()
	{
		$url1 = 'http://example.com/x/y/z';
		\Config::set('base_url', $url1);
		Session::set_back_url();
		$expected = array(
			'back_url' => null,
			'my_url' => $url1,
			);
		$actual = \Session::get('urls');
		$this->assertEquals($expected, $actual);

		$url2 = 'http://example.co.jp/a/b/c';
		\Config::set('base_url', $url2);
		Session::set_back_url();
		$expected = array(
			'back_url' => $url1,
			'my_url' => $url2,
			);
		$actual = \Session::get('urls');
		$this->assertEquals($expected, $actual);

		$expected = $url1;
		$actual = Session::back_url();
		$this->assertEquals($expected, $actual);
	}
}
