<?php
/**
 * Listview class
 *
 * @package app
 * @subpackage initKi
 * @author ksakamoto
 * @author kawamura.hryk
 * @author Takashi Kinoshita
 * @author ezaki3
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Listview
{
	const PAGINATION_NAME = 'mypagination';

	protected static $model = null;
	protected static $limit = 20;
	protected static $total = null;
	protected static $items = array();

	/**
	 * Create a new listview instance
	 *
	 * @param $model object Model|string Model name
	 * @param object This instance
	 */
	public static function forge($model)
	{
		return new static($model);
	}

	public function __construct($model)
	{
		if (gettype($model) == 'object')
		{
			static::$model = $model;
		}
		else
		{
			static::$model = $model::forge();
		}
	}

	public static function model()
	{
		return static::$model;
	}

	public function query(array $params = null){
		static $query = array();
		if (is_null($params)) return $query;
		$query = array_merge($query, $params);
		return $this;
	}

	public function create($pagination_url = null, array $default_conditions = null)
	{
		$model = static::$model;
		$query = $model::forge()
			->build_query($this->query(\Input::get())->query());
		$query = $this->default_conditions($query, $default_conditions);

		static::$total = $query->count();
		$limit = $this->limit();
		$config = array(
			'pagination_url' => $pagination_url,
			'total_items' => static::$total,
			'per_page' => $limit,
			'uri_segment' => 'page',
			);
		$pagination = \Pagination::instance(self::PAGINATION_NAME);
		if ( ! $pagination)
		{
			$pagination = \Pagination::forge(self::PAGINATION_NAME, $config);
		}

		$add_queries = array('limit' => $limit);
		if (($page = intval(\Input::get('page'))) > 1)
		{
			$add_queries['offset'] = ($page - 1) * $limit;
		}

		$query = $model::forge()
			->build_query($this->query($add_queries)->query());
		static::$items =
			$this->default_conditions($query, $default_conditions)->get();
		return $this;
	}

	protected function default_conditions(\Orm\Query $query, array $default_conditions = null)
	{
		foreach ($default_conditions as $key => $val)
		{
			$query->$key($val);
		}

		return $query;
	}

	public function limit($limit = null)
	{
		if ($limit)
		{
			static::$limit = $limit;
			return $this;
		}

		return static::$limit;
	}

	public static function total()
	{
		return static::$total;
	}

	public static function items()
	{
		return static::$items;
	}

	public static function pagination()
	{
		return \Pagination::instance(self::PAGINATION_NAME)->render();
	}

	public static function start()
	{
		return \Pagination::instance(self::PAGINATION_NAME)->offset + 1;
	}

	public static function end()
	{
		$pagination = \Pagination::instance(self::PAGINATION_NAME);
		return min(
			$pagination::offset + $pagination::per_page,
			$pagination->total_items);
	}
}
