<?php
/**
 * Auth Screen class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Auth_Screen extends Auth
{
	protected static $login_page = '/mypage/login/'; // Not login yet
	protected static $auth_home = '/mypage/'; //Already logged in

	public static function login_page()
	{
		return static::$login_page;
	}

	public static function auth_home()
	{
		return static::$auth_home;
	}

	protected static function brake()
	{
		\Response::redirect(static::$login_page);
	}

	protected static function through()
	{
		\Response::redirect(static::$auth_home);
	}
}
