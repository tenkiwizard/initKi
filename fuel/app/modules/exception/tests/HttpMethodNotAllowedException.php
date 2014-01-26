<?php

/**
 * HttpMethodNotAllowedException class Tests
 *
 * @group Modules
 */
class Test_HttpMethodNotAllowedException extends TestCase
{
	public function test_http_status()
	{
		$exception = new HttpMethodNotAllowedException();
		$response = $exception->response();
		$expected = 405;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new HttpMethodNotAllowedException();
		$response = $exception->response();
		$expected = 'MethodNotAllowed';
		$actual = $response->body->message;
		$this->assertEquals($expected, $actual);
	}
}
