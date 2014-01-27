<?php
/**
 * Lang class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Lang
{
	public static function detect_order()
	{
		\Config::load('Initki::encoding', 'enc');
		mb_detect_order(\Config::get('enc.detect_order'));
	}

	public static function set($lang)
	{
		\Session::set('language', $lang);
	}

	public static function get()
	{
		if ( ! $lang = \Session::get('language'))
		{
			$lang = \Config::get('language')
				? \Config::get('language')
				: \Config::get('language_fallback');
		}

		\Config::set('language', $lang);
		\Lang::load('title', 'title');
	}
}
