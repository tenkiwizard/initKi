<?php
namespace Initki;

/**
 * Http class Tests
 *
 * @group Modules
 */
class Test_Http extends \TestCase
{
	public function test_forge()
	{
		$expected = array(
			'url' => 'http://example.jp/',
			'method' => 'get',
			'auto_format' => true,
			);
		$actual = Http::forge('http://example.jp/')->configure();
		$this->assertEquals($expected, $actual);

		$expected = array(
			'url' => 'http://example.jp/2/',
			'method' => 'post',
			'auto_format' => false,
			);
		$actual = Http::forge('http://example.jp/2/', 'post', false)->configure();
		$this->assertEquals($expected, $actual);
	}

	public function test_configure()
	{
		$expected = array(
			'url' => 'http://example.jp/4/',
			'method' => 'put',
			'auto_format' => false,
			);
		Http::forge('http://example.jp/3/', 'get', true)
			->configure(array(
				'url' => 'http://example.jp/4/',
				'method' => 'put',
				'auto_format' => false,
				));
		$actual = Http::configure();
		$this->assertEquals($expected, $actual);
	}

	public function test_request_fail()
	{
		$url = 'http://example.com/';
		$stub = $this->getMock(
			'Initki\Http', array('execute'), array($url));
		$stub->expects($this->any())
			->method('execute')
			->will($this->throwException(
				new \RequestStatusException('fugahoge', 407)));
		$response = $stub->request()->response();

		$expected = 407;
		$actual = $response->status;
		$this->assertSame($expected, $actual);

		$expected = 'Proxy Authentication Required';
		$actual = $response->body;
		$this->assertEquals($expected, $actual);
	}

	public function test_request()
	{
		$url = 'http://example.com/';
		$stub = $this->getMock(
			'Initki\Http', array('execute'), array($url));
		$stub->expects($this->any())
			->method('execute')
			->will($this->returnValue(new \Response()));
		$expected = 200;
		$actual = $stub->request(
			array('id' => 123, 'name' => 'fuga'))->response()->status;
		$this->assertSame($expected, $actual);
		/////
		$this->markTestIncomplete();
		/////
	}

	public function test_correct_protocol_http_to_https()
	{
		$stub = $this->getMock(
			'Initki\Http', array('protocol', 'current', 'redirect'), array(''));
		$stub::staticExpects($this->any())
			->method('protocol')->will($this->returnValue('http'));
		$stub::staticExpects($this->any())
			->method('redirect')->will($this->returnArgument(0));
		$stub::staticExpects($this->any())
			->method('current')->will($this->returnValue('http://example.com/a/b/c'));
		$expected = 'https://example.com/a/b/c';
		$actual = $stub::correct_protocol(true);
		$this->assertEquals($expected, $actual);
	}

	public function test_correct_protocol_http()
	{
		$stub = $this->getMock(
			'Initki\Http', array('protocol', 'current', 'redirect'), array(''));
		$stub::staticExpects($this->any())
			->method('protocol')->will($this->returnValue('https'));
		$stub::staticExpects($this->any())
			->method('redirect')->will($this->returnArgument(0));
		$stub::staticExpects($this->any())
			->method('current')->will($this->returnValue('https://example.com/x/y/z'));
		$this->assertNull($stub::correct_protocol(true));
	}

	public function test_correct_protocol_https_to_http()
	{
		$stub = $this->getMock(
			'Initki\Http', array('protocol', 'current', 'redirect'), array(''));
		$stub::staticExpects($this->any())
			->method('protocol')->will($this->returnValue('https'));
		$stub::staticExpects($this->any())
			->method('redirect')->will($this->returnArgument(0));
		$stub::staticExpects($this->any())
			->method('current')->will($this->returnValue('https://example.com/x/y/z'));
		$expected = 'http://example.com/x/y/z';
		$actual = $stub::correct_protocol(false);
		$this->assertEquals($expected, $actual);
	}

	public function test_correct_protocol_https()
	{
		$stub = $this->getMock(
			'Initki\Http', array('protocol', 'current', 'redirect'), array(''));
		$stub::staticExpects($this->any())
			->method('protocol')->will($this->returnValue('http'));
		$stub::staticExpects($this->any())
			->method('redirect')->will($this->returnArgument(0));
		$stub::staticExpects($this->any())
			->method('current')->will($this->returnValue('http://example.com/x/y/z'));
		$this->assertNull($stub::correct_protocol(false));
	}

	public function test_correct_protocol_is_https_and_exits()
	{
		$stub = $this->getMock('Initki\Http', array('protocol'), array(''));
		$stub::staticExpects($this->any())
			->method('protocol')->will($this->returnValue('http'));
		$this->setExpectedException('HttpNotFoundException');
		$stub::correct_protocol(true, true);
	}

	public function test_correct_protocol_is_http_and_exists()
	{
		$stub = $this->getMock('Initki\Http', array('protocol'), array(''));
		$stub::staticExpects($this->any())
			->method('protocol')->will($this->returnValue('https'));
		$this->setExpectedException('HttpNotFoundException');
		$stub::correct_protocol(false, true);
	}

	public function test_no_chache()
	{
		$response = new \Response();
		Http::no_cache($response);

		$test = $response->get_header('Cache-Control');
		$expected = 'no-cache, no-store, must-revalidate, post-check=0, pre-check=0';
		$this->assertEquals($expected, $test);

		$test = $response->get_header('Pragma');
		$expected = 'no-cache';
		$this->assertEquals($expected, $test);

		$test = $response->get_header('Expires');
		$expected = 'Thu, 19 Nov 1981 08:52:00 GMT';
		$this->assertEquals($expected, $test);
	}

	public function test_no_sniff()
	{
		$response = new \Response();
		Http::no_sniff($response);
		$this->assertEquals(
			'nosniff', $response->get_header('X-Content-Type-Options'));
	}
}
