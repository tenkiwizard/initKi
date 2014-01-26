<?php
/**
 * Model interface
 *
 * @package app
 * @subpackage Query
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Query;

interface Model_Interface
{
	public static function table();

	public static function properties();

	public static function query();

	public static function query_conditions();

	public function build_query();

	//public function get();

	//public static function get_one();
}
