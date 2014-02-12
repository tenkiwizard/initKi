<?php
/**
 * Session class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Session
{
	/**
	 * Same as Fuel\Core\Session_Driver::_serialize()
	 */
	public static function serialize($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				if (is_string($val))
				{
					$data[$key] = str_replace('\\', '{{slash}}', $val);
				}
			}
		}
		else
		{
			if (is_string($data))
			{
				$data = str_replace('\\', '{{slash}}', $data);
			}
		}

		return serialize($data);
	}

	public static function encoded()
	{
		return \Crypt::encode(static::serialize(array(\Session::key())));
	}

	public static function name()
	{
		\Config::load('session', true);
		return \Config::get('session.'.\Config::get('session.driver').'.cookie_name');
	}

	public static function set_back_url()
	{
		\Session::set('urls.back_url', \Session::get('urls.my_url'));

		$my_url = \Uri::current();
		if ($get = \Input::get())
		{
			$my_url .= '?'.http_build_query($get);
		}

		\Session::set('urls.my_url', $my_url);
	}

	public static function back_url()
	{
		return \Session::get('urls.back_url');
	}
}
