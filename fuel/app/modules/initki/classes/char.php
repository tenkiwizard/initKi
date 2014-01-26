<?php
/**
 * Char class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Char
{
	/**
	 * Default
	 * 英数→半角、半角ｶﾅ→全角カナ
	 */
	public static function normalize($word)
	{
		return mb_convert_kana($word, 'aKV');
	}

	/**
	 * Default + 英→小文字
	 */
	public static function normalizel($word)
	{
		return strtolower(static::normalize($word));
	}

	/**
	 * Default + ひらがな→全角カタカナ
	 */
	public static function normalizek($word)
	{
		return mb_convert_kana(static::normalize($word), 'C');
	}

	/**
	 * 全て→全角
	 */
	public static function fullwidth($word)
	{
		return mb_convert_kana(static::normalize($word), 'AKS');
	}
}
