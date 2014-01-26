<?php
/**
 * Abstract API controller
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Controller_Api extends Controller_Restful
{
	public function router($namespace, $params)
	{
		if ($namespace == 'index') // Unspecified namespace
		{
			throw new \HttpNotFoundException();
		}

		parent::router($namespace, $params);
		static::$model = \Inflector::classify(
			$namespace.'\\model_'.array_shift($params));
		if (class_exists(static::$model))
		{
			$this->response->status = 200;
			$this->get_index($params);
			return;
		}

		throw new \HttpNotFoundException();
	}
}
