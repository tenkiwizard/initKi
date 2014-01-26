<?php
/**
 * Abstract Auth class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Auth
{
	protected static $needs_auth = false;
	protected static $auth_omit_actions = array();
	protected static $needs_unauth = false;

	public static function check($needs_auth, array $auth_omit_actions, $needs_unauth)
	{
		static::$needs_auth = $needs_auth;
		static::$auth_omit_actions = $auth_omit_actions;
		static::$needs_unauth = $needs_unauth;

		if (static::$needs_auth)
		{
			return static::needs_auth();
		}
		elseif (static::$needs_unauth)
		{
			return static::needs_unauth();
		}

		return true;
	}

	protected static function needs_auth()
	{
		if ( ! in_array(static::action(), static::$auth_omit_actions) and
			 ! static::is_auth())
		{
			return static::brake();
		}

		return true;
	}

	protected static function needs_unauth()
	{
		if (static::is_auth())
		{
			return static::through();
		}

		return true;
	}

	protected static function action()
	{
		return \Request::active()->action;
	}

	protected static function is_auth()
	{
		return \Auth::check();
	}

	protected static function brake() {}

	protected static function through() {}
}
