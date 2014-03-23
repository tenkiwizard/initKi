<?php

/**
 * Extended Request Driver class
 *
 * @package app
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */
abstract class Request_Driver extends Fuel\Core\Request_Driver
{
	/**
	 * @override
	 */
	protected static $auto_detect_formats = array(
		'application/xml' => 'xml',
		'text/xml' => 'xml',
		'application/json' => 'json',
		'application/json; charset=utf-8' => 'json', // Add this
		'text/json' => 'json',
		'text/csv' => 'csv',
		'application/csv' => 'csv',
		'application/vnd.php.serialized' => 'serialize',
	);
}
