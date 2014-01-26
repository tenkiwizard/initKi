<?php

/**
 * HttpInvalidInputException class Tests
 *
 * @group Modules
 */
class Test_HttpInvalidInputException extends TestCase
{
	public function test_http_status()
	{
		$exception = new HttpInvalidInputException();
		$response = $exception->response();
		$expected = 400;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new HttpInvalidInputException();
		$response = $exception->response();
		$expected = 'Invalid Input';
		$actual = $response->body->message;
		$this->assertEquals($expected, $actual);
	}
}
