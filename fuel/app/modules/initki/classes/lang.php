<?php
/**
 * Lang class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Lang
{
	public static function detect_order()
	{
		\Config::load('Initki::encoding', 'enc');
		mb_detect_order(\Config::get('enc.detect_order'));
	}
}
