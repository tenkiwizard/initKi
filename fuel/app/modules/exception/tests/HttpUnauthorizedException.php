<?php

/**
 * HttpForbiddenException class Tests
 *
 * @group Modules
 */
class Test_HttpUnauthorizedException extends TestCase
{
	public function test_http_status()
	{
		$exception = new HttpUnauthorizedException();
		$response = $exception->response();
		$expected = 401;
		$actual = $response->status;
		$this->assertEquals($expected, $actual);
	}

	public function test_display_message()
	{
		$exception = new HttpUnauthorizedException();
		$response = $exception->response();
		$expected = 'Unauthorized';
		$actual = $response->body->message;
		$this->assertEquals($expected, $actual);
	}
}
