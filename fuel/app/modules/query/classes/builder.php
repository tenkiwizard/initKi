<?php
/**
 * Query builder abstract class
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @author ksakamoto
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

abstract class Builder implements Builder_Interface
{
	protected $uses_orm_query = true;
	protected $or_where_groups = array();
	protected $period_property = '';
	protected $max_limit = 1000;

	protected static $query = null;

	protected $selects = array();
	protected $wheres = array();
	protected $or_wheres = array();

	protected static $model = null;

	protected static $validation = null; // For instance of \Query\Validation

	public static function forge($model)
	{
		return new static($model);
	}

	public function __construct($model)
	{
		static::$model = $model;
		static::$query = $model->query();
		foreach ($model->query_conditions() as $key => $val)
		{
			$this->{$key} = $val;
		}

		static::$validation = Validation::forge();
	}

	protected function add_field($name, $label, $rules)
	{
		static $validated = array();
		if (in_array($name, $validated)) return;
		$validated[] = $name;
		static::$validation->instance()->add_field($name, $label, $rules);
	}

	public function validate(array $params, $allow_partial = false)
	{
		$this->add_field('limit', 'limit', 'valid_string[numeric]');
		$this->add_field('offset', 'offset', 'valid_string[numeric]');
		static::$validation->instance()->add_callable(get_called_class());
		$this->add_field('order', 'order', 'has');
		static::$validation->instance()->add_callable('Initki\ValidationRules');
		$this->add_field('direction', 'direction', 'in[asc:desc]');
		$this->add_field('from', 'from', 'valid_string[numeric]');
		$this->add_field('to', 'to', 'valid_string[numeric]');
		if ( ! static::$validation->validate($params, $allow_partial)->is_valid())
		{
			throw new \HttpInvalidParameterException();
		}

		return $this;
	}

	public function is_valid()
	{
		return static::$validation->is_valid();
	}

	public static function _validation_has($value)
	{
		return static::$validation->instance()->_empty($value) or
			static::has_property($value);
	}

	public static function has_property($name)
	{
		$name = preg_replace('/^'.static::$model->table().'\./i', '', $name);
		return array_key_exists($name, static::$model->properties());
	}

	public static function query()
	{
		return static::$query;
	}

	public function build(array $params = null)
	{
		if (is_null($params))
		{
			// build by validated params if arguments are not given
			$params = static::$validation->instance()->validated();
		}

		$this->select();
		if (method_exists(static::$model, 'convert_params'))
		{
			static::$model->convert_params($params);
		}

		$this->conditions($params);
		$this->where($params);
		// return some object in sub classe
	}

	abstract public function select(array $selects = null);

	public function where(array $params)
	{
		$this->build_or_wheres($params);
		$this->build_wheres($params);
		$this->add_wheres();
		return $this;
	}

	protected function build_or_wheres(array &$params) {}

	protected function build_wheres(array &$params) {}

	protected function add_wheres() {}

	public function conditions(array $params)
	{
		static::period($params);
		static::order($params);
		static::limit($params);
		return $this;
	}

	protected function period(array $params) {}

	protected function order(array $params) {}

	protected function limit(array $params)
	{
		$limit = \Arr::get($params, 'limit');
		if ($this->max_limit)
		{
			if ( ! $limit or $limit > $this->max_limit)
			{
				$limit = $this->max_limit;
			}
		}

		if ($limit)
		{
			static::$query->limit($limit);
		}

		if ( ! empty($params['offset']))
		{
			static::$query->offset($params['offset']);
		}
	}
}
