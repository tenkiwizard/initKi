<?php
/**
 * Utilities support multi device
 * including featurephones and smartphones in Japan
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Device
{
	const FEATUREPHONE_ENCODING = 'SJIS-win';

	public static function from_featurephone($value)
	{
		if ( ! static::is_featurephone()) return $value;
		if (is_array($value)) return $value;

		$new_value = mb_convert_encoding(
			$value, \Fuel::$encoding, self::FEATUREPHONE_ENCODING);
		return $new_value;
	}

	public static function to_featurephone($value)
	{
		if ( ! static::is_featurephone()) return $value;
		if (is_array($value)) return $value;

		$new_value = mb_convert_kana($value, 'ak');
		$new_value = mb_convert_encoding(
			$new_value, self::FEATUREPHONE_ENCODING, \Fuel::$encoding);
		return $new_value;
	}

	public static function url_session($value)
	{
		if ( ! static::is_featurephone()) return $value;
		if (is_array($value)) return $value;

		$param = Session::name().'='.Session::encoded();
		$new_value = preg_replace(
			'/(\s)(href|action)="([^\?"]*)\??(.*?)"/is',
			'$1$2="$3?'.$param.'&$4"',
			$value);
		// お尻に&が付いているとページ内リンクがうまくいかないので削除
		$new_value = preg_replace(
			'/(\s)(href|action)="(.*?)\&?"/is',
			'$1$2="$3"',
			$new_value);
		// ページ内リンクはクエリストリングの後に
		$new_value = preg_replace(
			'/(\s)(href|action)="([^#"]*)#([^\?"]*)(.*?)"/is',
			'$1$2="$3$5#$4"',
			$new_value);
		// ページ内リンクのみの場合はセッションIDを削除
		$new_value = preg_replace(
			'/(\s)(href|action)="\?'.$param.'#([^\?"]*)"/is',
			'$1$2="#$3"',
			$new_value);
		return $new_value;
	}

	public static function is_featurephone()
	{
		$uas = array(
			'UP\.Browser',
			'KDDI',
			'DoCoMo',
			'J-PHONE',
			'Vodafone',
			'SoftBank',
			'MOT-',
			'L-mode',
			'DDIPOCKET',
			'WILLCOM',
			'PDXGW',
			'ASTEL',
			);

		return static::is_ua_match($uas);
	}

	public static function is_smartphone()
	{
		$uas = array(
			'iPhone',
			'iPod',
			'Android.*Mobile',
			'Windows.*Phone',
			'dream',
			'blackberry',
			'CUPCAKE',
			'webOS',
			'incognito',
			'webmate',
			);

		return static::is_ua_match($uas);
	}

	private static function is_ua_match($uas)
	{
		$pattern = '/'.implode('|', $uas).'/';
		$ua = $_SERVER['HTTP_USER_AGENT'];

		if (preg_match($pattern, $ua))
		{
			return true;
		}

		return false;
	}
}
