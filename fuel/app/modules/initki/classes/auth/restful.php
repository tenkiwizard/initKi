<?php
/**
 * Auth Restful class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Auth_Restful extends Auth
{
	protected static function brake()
	{
		throw new \HttpUnauthorizedException();
		\Response::redirect(static::$login_page);
	}

	protected static function through()
	{
		return true;
	}
}
