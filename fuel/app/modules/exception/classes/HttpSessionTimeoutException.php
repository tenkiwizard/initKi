<?php

/**
 * HTTP Session timeout exception
 *
 * @package  app
 * @author kawamura.hryk
 * @author nakaishi.nryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class HttpSessionTimeoutException extends HttpException
{
	protected static $data = array(
		'message' => 'SessionTimeout',
		);
}
