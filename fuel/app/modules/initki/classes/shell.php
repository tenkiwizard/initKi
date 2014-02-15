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
	 * @var string Shell script file
	 */
	protected static $file = '';

	/**
	 * @var string Shell script file path
	 */
	protected static $path = '';

	/**
	 *
	 *
	 * @param mixed Variable-length argument lists
	 * @return string Stdout or null when error
	 */
	public static function exec()
	{
		$args = func_get_args();
		if (static::$script)
		{
			$command_line = static::command_line_from_script($args);
		}
		elseif (static::$file)
		{
			$command_line = static::command_line_from_file($args);
		}
		else
		{
			throw new \RuntimeException('Not defined neither script nor file');
		}

		return shell_exec($command_line);
	}

	protected static function command_line_from_script($args)
	{
		$meta = stream_get_meta_data(tmpfile());
		file_put_contents($meta['uri'], static::$script);
		$command_line = implode(
			' ', array_merge(array(static::SHELL, $meta['uri']), $args));
		return $command_line;
	}

	protected static function command_line_from_file($args)
	{
		$file = static::$path.'/'.static::$file;
		if ( ! is_readable($file))
		{
			throw new \RuntimeException('File is not readable: '.$file);
		}

		$command_line = implode(
			' ', array_merge(array(static::SHELL, $file), $args));
		return $command_line;
	}
}
