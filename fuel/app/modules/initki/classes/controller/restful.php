<?php
/**
 * Abstract controller for RESTful API
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Controller_Restful extends \Controller_Rest
{
	protected $_supported_formats = array(
		'xml' => 'application/xml',
		'json' => 'application/json',
		'jsonp' => 'text/javascript',
		);

	protected static $needs_ssl = false;

	protected static $needs_auth = false;
	protected static $auth_omit_actions = array();
	protected static $needs_unauth = false;

	protected static $model = null; // define in sub class

	public function before()
	{
		parent::before();
		Http::correct_protocol(static::$needs_ssl, true);
		static::auth();
	}

	protected static function auth()
	{
		Auth_Restful::check(
			static::$needs_auth,
			static::$auth_omit_actions,
			static::$needs_unauth
			);
	}

	public function get_index()
	{
		$model = static::$model;
		$results = $model::forge()->build_query(\Input::get())->get();
		static::proc_results($results);
		$this->response($results);
	}

	protected static function proc_results(array &$results)
	{
		if (empty($results)) return $results;
		$proced = array();
		foreach ($results as $result)
		{
			if (is_object($result)) // ここ省けないかなあ？
			{
				$result = $result->to_array();
			}

			static::do_proc($result);
			$proced[] = $result;
		}

		$results = $proced;
	}

	protected static function do_proc(array &$result)
	{
		// implement on sub class if you need
	}
}
