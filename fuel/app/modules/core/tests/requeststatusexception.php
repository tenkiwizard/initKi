<?php

/**
 * RequestStatusException class Tests
 *
 * @group Modules
 */
class Test_RequestStatusException extends TestCase
{
	public function test_http_status()
	{
		$exception = new RequestStatusException('fugahoge', 407);
		$response = $exception->response();
		$expected = 407;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new RequestStatusException('fugahoge', 407);
		$response = $exception->response();
		$expected = 'Proxy Authentication Required';
		$actual = $response->body;
		$this->assertEquals($expected, $actual);
	}
}
