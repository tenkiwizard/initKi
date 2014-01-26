<?php

/**
 * HttpForbiddenException class Tests
 *
 * @group Modules
 */
class Test_HttpForbiddenException extends TestCase
{
	public function test_http_status()
	{
		$exception = new HttpForbiddenException();
		$response = $exception->response();
		$expected = 403;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new HttpForbiddenException();
		$response = $exception->response();
		$expected = 'Forbidden';
		$actual = $response->body->message;
		$this->assertEquals($expected, $actual);
	}
}
