<?php
/**
 * Abstract API controller to check input values for ajax
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Controller_Api_Validation extends Controller_Restful
{
	public function router($namespace, $params)
	{
		parent::router($namespace, $params);
		$parts = explode('_', array_shift($params));
		$end = count($parts);

		for ($len = $end; $len > 0; $len--)
		{
			$method = join('_', array_slice($parts, 0, $len));
			static::$model = \Inflector::classify($namespace.'\\model_'.$method);
			if ( class_exists(static::$model))
			{
				$this->action_index($params);
				return;
			}
		}

		throw new \HttpNotFoundException();
	}

	public function action_index($params = null)
	{
		$inputs = array();
		$allow_partial = false;
		if (empty($params))
		{
			$inputs = \Input::param();
		}
		else
		{
			foreach (\Input::param() as $key => $val)
			{
				in_array($key, $params) and $inputs[$key] = $val;
			}

			//$allow_partial = true;
		}

		$model = static::$model;
		$results['errors'] = $model::forge()
			->validate($inputs, $allow_partial)->errors($params);
		//static::proc_results($results);

		$this->response($results, 200);
	}
}
