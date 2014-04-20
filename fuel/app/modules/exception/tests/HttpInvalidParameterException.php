<?php

/**
 * HttpInvalidParameterException class Tests
 *
 * @group Modules
 */
class Test_HttpInvalidParameterException extends TestCase
{
	public function test_http_status()
	{
		$exception = new HttpInvalidParameterException();
		$response = $exception->response();
		$expected = 400;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new HttpInvalidParameterException();
		$response = $exception->response();
		$expected = 'Invalid Parameter';
		$actual = $response->body->message;
		$this->assertEquals($expected, $actual);
	}
}
