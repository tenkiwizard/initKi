<?php
/**
 * Validation wrapper
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

class Validation
{
	private static $validation = null;
	private static $is_valid = false;

	public static function forge()
	{
		static::instance();
		return new static();
	}

	public static function instance()
	{
		static::$validation = \Validation::instance(get_called_class()); // 識別子的に呼び出し元クラス名を使用
		if ( ! static::$validation)
		{
			static::$validation = \Validation::forge(get_called_class());
		}

		return static::$validation;
	}

	public function validate(array $params = null, $allow_partial = false)
	{
		static::$is_valid =
			static::$validation->run($params, $allow_partial) ? true : false;
		return $this;
	}

	public function is_valid()
	{
		return static::$is_valid;
	}

	public static function errors(array $params = null)
	{
		$errors = array();
		foreach (static::$validation->error() as $name => $error)
		{
			if (empty($params) or in_array($name, $params))
			{
				$error_obj = new \ArrayObject(
					array(), \ArrayObject::ARRAY_AS_PROPS);
				$error_obj->name = $name;
				$error_obj->message = $error->get_message();
				$errors[] = $error_obj;
			}
		}

		return $errors;
	}
}
