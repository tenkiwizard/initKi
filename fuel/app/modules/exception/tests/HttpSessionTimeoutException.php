<?php

/**
 * HttpSessionTimeoutException class Tests
 *
 * @group Modules
 */
class Test_HttpSessionTimeoutException extends TestCase
{
	public function test_http_status()
	{
		$exception = new HttpSessionTimeoutException();
		$response = $exception->response();
		$expected = 400;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new HttpSessionTimeoutException();
		$response = $exception->response();
		$expected = 'SessionTimeout';
		$actual = $response->body->message;
		$this->assertEquals($expected, $actual);
	}
}
