<?php
/**
 * Query builder sourced data from DB
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @author ksakamoto
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

class Builder_Db extends Builder
{
	public function __toString()
	{
		if ($this->uses_orm_query)
		{
			return static::$query->get_query()->__toString();
		}

		return static::$query->__toString();
	}

	public function get()
	{
		if ($this->uses_orm_query)
		{
			throw new \BadMethodCallException('This method can NOT be called when uses orm query');
		}

		return static::$query->as_object('Model_Crud')->execute()->as_array();
	}
	
	public function count()
	{
		if ($this->uses_orm_query)
		{
			throw new \BadMethodCallException('This method can NOT be called when uses orm query');
		}

		return static::$query->limit(null)->execute()->count();
	}

	public function build(array $params = null)
	{
		parent::build($params);
		return static::$query;
	}

	public function select(array $selects = null)
	{
		if ( ! is_null($selects))
		{
			$this->selects = $selects;
		}

		if ($this->uses_orm_query)
		{
			foreach ($this->selects as $col)
			{
				static::$query->select($col);
			}
		}
		else
		{
			if (empty($this->selects))
			{
				static::$query = \DB::select('*')->from(static::$model->table());
			}
			else
			{
				static::$query = \DB::select()->from(static::$model->table());
				foreach ($this->selects as $col)
				{
					static::$query->select($col);
				}
			}
		}

		return $this;
	}

	protected function build_or_wheres(array &$params)
	{
		$or_where_groups = array();
		$used_params = array();
		foreach ($params as $key => $val)
		{
			if (array_key_exists($key, $this->or_where_groups))
			{
				if ( ! is_null($val))
				{
					$or_where_groups[$this->or_where_groups[$key]][$key] = $val;
					$used_params[] = $key;
				}
			}
		}

		foreach ($used_params as $used)
		{
			unset($params[$used]);
		}

		foreach ($or_where_groups as $vals)
		{
			static::$query->where_open();
			foreach ($vals as $skey => $sval)
			{
				static::$query->or_where($skey, $sval);
			}

			static::$query->where_close();
		}
	}

	protected function build_wheres(array &$params)
	{
		foreach ($params as $key => $val)
		{
			if ( ! is_null($val) and static::has_property($key))
			{
				if (strpos($val, ',') !== false)
				{
					/** @todo Not supported (or_where_groups && multiple value) YET! */
					$this->or_wheres[$key] = explode(',', $val);
				}
				else
				{
					$this->wheres[] = array($key => $val);
				}
			}
		}
	}

	protected function add_wheres()
	{
		foreach ($this->wheres as $where)
		{
			static::$query->where($where);
		}

		foreach ($this->or_wheres as $key => $vals)
		{
			static::$query->where_open();
			foreach ($vals as $val)
			{
				static::$query->or_where($key, $val);
			}

			static::$query->where_close();
		}
	}

	protected function period(array $params)
	{
		if ( ! empty($params['from']))
		{
			static::$query->where($this->period_property, '>=', $params['from']);
		}

		if ( ! empty($params['to']))
		{
			static::$query->where($this->period_property, '<=', $params['to']);
		}
	}

	protected function order(array $params)
	{
		$order = '';
		if ( ! empty($params['order']))
		{
			$order = $params['order'];
			$direction = 'asc';
			if ( ! empty($params['direction']) and $params['direction'] == 'desc')
			{
				$direction = 'desc';
			}

			// Multiple direction is not supported yet
			static::$query->order_by($order, $direction);
		}

		foreach ($this->selects as $select)
		{
			if (is_string($select) and
				array_key_exists($select, static::$model->properties()) and
				$select != $order)
			{
				static::$query->order_by($select, 'asc');
			}
		}
	}
}
