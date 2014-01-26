<?php
/**
 * Builder interface
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

interface Builder_Interface
{
	public function validate(array $params);

	public function is_valid();

	public static function _validation_has($value);

	public static function has_property($name);

	public static function query();

	public function build(array $params = null);

	public function select(array $selects = null);
}
