<?php
/**
 * Mime class
 *
 * @package  app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Mime
{
	public static function decode($str)
	{
		$str = mb_decode_mimeheader($str);
		$convert_to = \Fuel::$encoding;
		$convert_from = mb_detect_encoding($str);
		return mb_convert_encoding($str, $convert_to, $convert_from);
	}

	public static function encode($str)
	{
		return mb_encode_mimeheader($str, \Fuel::$encoding);
	}
}
