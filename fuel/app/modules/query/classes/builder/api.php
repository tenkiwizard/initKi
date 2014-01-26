<?php
/**
 * Query builder sourced data from external Web-API
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

class Builder_Api extends Builder implements Builder_Interface
{
	/**
	 * @todo Implement
	 */
	public function select(array $selects = null) {}

	/*
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
	 */

	protected function limit(array $params) {}
}
