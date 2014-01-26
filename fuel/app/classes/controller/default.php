<?php
/**
 * Default routing controller
 *
 * @package app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
class Controller_Default extends Initki\Controller_Screen
{
	public function action_index()
	{
		$this->title()->content();
	}

	public function action_404()
	{
		if ( ! $this->_pages())
		{
			return Response::forge(View::forge('404'), 404);
		}
	}

	public function action_500()
	{
		throw new HttpServerErrorException();
	}

	/**
	 * Render static pages if title config and content view are exist
	 *
	 * @todo implement
	 */
	private function _pages()
	{
		$content_name = substr(Input::uri(), 1);

		try
		{
			$this->title()->content();
		}
		catch (FuelException $e)
		{
			return false;
		}

		return true;
	}
}
