<?php
/**
 * Abstract controller for web screen with themes, authentication and authorization
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Controller_Screen extends \Controller
{
	protected $template = null;
	protected static $template_file = 'template';
	protected static $data = array();
	protected static $needs_ssl = false;

	protected static $needs_auth = false;
	protected static $auth_omit_actions = array();
	protected static $needs_unauth = false;

	public function before()
	{
		parent::before();
		Http::correct_protocol(static::$needs_ssl);
		static::auth();
		$this->proc_template();
	}

	protected static function auth()
	{
		Auth_Screen::check(
			static::$needs_auth,
			static::$auth_omit_actions,
			static::$needs_unauth
			);
	}

	protected function proc_template()
	{
		$this->template = \Theme::instance()
			->set_template(static::$template_file);
	}

	protected function title($title = null)
	{
		if (is_null($title))
		{
			$title_str = __('title.'.$this->page_id());
		}
		else
		{
			$title_str = __('title.'.$title);
		}

		if (empty($title_str))
		{
			$title_str = $title;
		}

		$this->template->set_global('title',  $title_str);
		return $this;
	}

	protected function content($view = null, $auto_filter = null)
	{
		if (is_null($view))
		{
			$view = $this->page_id();
		}

		$theme = \Theme::instance();
		$this->template->content = $theme->view(
			$view, static::$data, $auto_filter);
		return $this;
	}

	protected function page_id()
	{
		return Inflector::viewerize(get_class($this), \Request::active()->action);
	}

	public function after($response)
	{
		if (empty($response) or ! $response instanceof \Response)
		{
			$response = \Response::forge(\Theme::instance()->render());
		}

		$response = parent::after($response);

		$this->proc_response($response);

		return $response;
	}

	public function proc_response(\Response $response)
	{
		Http::no_sniff($response);
		if (static::$needs_ssl)
		{
			Http::no_cache($response);
		}
	}

	protected static function check_token()
	{
		if ( ! Security::check_token())
		{
			throw new HttpSessionTimeoutException();
		}
	}
}
