<?php
/**
 * Shell execute abstract class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

abstract class Shell
{
	const SHELL = '/bin/bash';

	/**
	 * @var string Shell script lines
	 */
	protected static $script = '';

	/**
	 *
	 *
	 * @param mixed 可変長引数リスト
	 * @return string Stdout or null when error
	 */
	public static function exec()
	{
		$args = func_get_args();
		$meta = stream_get_meta_data(tmpfile());
		file_put_contents($meta['uri'], static::$script);
		$command_line = implode(
			' ', array_merge(array(self::SHELL, $meta['uri']), $args));
		return shell_exec($command_line);
	}
}
