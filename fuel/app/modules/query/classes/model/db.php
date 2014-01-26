<?php
/**
 * Model sourced data from DB
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

abstract class Model_Db extends \Orm\Model implements Model_Interface
{
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
			),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
			),
		);

	protected static $query_builder = null;
	protected static $query_conditions = array(
		'uses_orm_query' => true,
		'or_where_groups' => array(),
		'period_property' => 'updated_at',
		'max_limit' => 0, // zero means unlimited
		'selects' => array(),
		'wheres' => array(),
		'or_wheres' => array(),
		);

	protected static $validation = null; // For instance of \Query\Validation

	public function __construct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);
		static::$query_builder = Builder_Db::forge($this);
		static::$validation = Validation::forge();
	}

	public function validate(array $params = null, $allow_partial = false)
	{
		static $validated = false; // builderの方式と合わせるべきか
		if ($validated)
		{
			return $this;
		}

		$this->validations();
		static::$validation->validate($params, $allow_partial);
		$validated = true;
		return $this;
	}

	protected function validations()
	{
		// Add validation rules in sub class like below

		//$val = static::$validation->instance();
		//$val->add_field('id', 'User ID', 'valid_string[numeric]');
	}

	public function validation()
	{
		return static::$validation;
	}

	public function is_valid()
	{
		return static::$validation->is_valid();
	}

	public static function query_conditions()
	{
		return static::$query_conditions;
	}

	public function build_query(array $params = array(), $validate = false)
	{
		if ($validate)
		{
			$this->validate($params);
			static::$query_builder->validate($params)->build();
		}
		else
		{
			static::$query_builder->build($params);
		}

		if ( ! static::$query_conditions['uses_orm_query'])
		{
			return static::$query_builder;
		}

		return static::$query_builder->query();
	}

	public static function convert_params(array &$params)
	{
		foreach ($params as $key => $val)
		{
			if ($val === '')
			{
				unset($params[$key]); // ignore the parameter if value is empty string
			}
			elseif (strpos($key, '::'))
			{
				// TODO Consider
				$params[str_replace('::', '.', $key)] = $val;
				unset($params[$key]);
			}
		}
	}
}
