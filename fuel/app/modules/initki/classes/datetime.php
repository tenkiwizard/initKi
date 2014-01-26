<?php
/**
 * Date / Time related utility class
 *
 * @package  app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Datetime
{
	const INTERVAL_CHAR_DATE_PREFIX = 'P'; // means 'period'
	const INTERVAL_CHAR_YEAR = 'Y';
	const INTERVAL_CHAR_MONTH = 'M';
	const INTERVAL_CHAR_WEEK = 'W';
	const INTERVAL_CHAR_DAY = 'D';
	const INTERVAL_CHAR_TIME_PREFIX = 'T';
	const INTERVAL_CHAR_HOUR = 'H';
	const INTERVAL_CHAR_MINUTE = 'M';
	const INTERVAL_CHAR_SECOND = 'S';

	private function __construct() {}

	/**
	 * PHP\Dateinterval書式文字列に変換して返す
	 */
	public static function interval_str(array $datetime)
	{
		if (isset($datetime['day']) and isset($datetime['week']))
		{
			return false; // PHP\Datetime的に'日'と'週'を同時には使えない
		}

		$interval_str = self::INTERVAL_CHAR_DATE_PREFIX;
		$interval_str .=
			(isset($datetime['year'])) ?
				$datetime['year'].self::INTERVAL_CHAR_YEAR : '';
		$interval_str .=
			(isset($datetime['month'])) ?
				$datetime['month'].self::INTERVAL_CHAR_MONTH : '';
		$interval_str .=
			(isset($datetime['day'])) ?
				$datetime['day'].self::INTERVAL_CHAR_DAY : '';
		$interval_str .=
			(isset($datetime['week'])) ?
				$datetime['week'].self::INTERVAL_CHAR_WEEK : '';
		if (isset($datetime['hour']) or
			isset($datetime['minute']) or
			isset($datetime['second']))
		{
			$interval_str .= self::INTERVAL_CHAR_TIME_PREFIX;
			$interval_str .=
				(isset($datetime['hour'])) ?
					$datetime['hour'].self::INTERVAL_CHAR_HOUR : '';
			$interval_str .=
				(isset($datetime['minute'])) ?
					$datetime['minute'].self::INTERVAL_CHAR_MINUTE : '';
			$interval_str .=
				(isset($datetime['second'])) ?
					$datetime['second'].self::INTERVAL_CHAR_SECOND : '';
		}

		return $interval_str;
	}

	/**
	 * 日時書式変更
	 * （日時妥当性チェックにも使えるかも）
	 */
	public static function format($str, $format = 'y/m/d H:i')
	{
		if (strlen($str) === 0)
		{
			return true;
		}

		try
		{
			$datetime = new \Datetime($str);
		}
		catch (\Exception $e)
		{
			// 不正な日付とか
			return false;
		}
		// @todo さらに厳密なチェックする？

		$ret = $datetime->format($format);
		unset($datetime);
		return $ret;
	}

	/**
	 * 実在する年月日かどうかの寛容な検証
	 */
	public static function is_valid_date($str)
	{
		$str = trim($str);
		if (strlen($str) === 0)
		{
			return true;
		}

		if ( ! strtotime($str))
		{
			return false;
		}

		if (preg_match('/[^0-9]/', $str))
		{
			list($year, $mon, $day) = preg_split('/[^0-9]/', $str);
			$date1 = sprintf('%04d%02d%02d', $year, $mon, $day);
		}
		else
		{
			$date1 = $str;
		}

		$date2 = date('Ymd', strtotime($date1));
		return $date1 == $date2;
	}

	/**
	 * from マイナス to の日数を符号付き整数で返す
	 */
	public static function diff($from, $to)
	{
		if ( ! self::is_valid_date($from) or ! self::is_valid_date($to))
		{
			return false;
		}

		$datetime1 = new \DateTime($from);
		$datetime2 = new \DateTime($to);
		$interval = (int) $datetime2->diff($datetime1)->format('%R%a');
		unset($datetime1, $datetime2);
		return $interval;
	}

	/**
	 * 日付文字列を受け取り、指定期間後の日付文字列を返す
	 */
	public static function add($date_str, $interval_str, $format = 'Ymd')
	{
		return static::_calc('add', $date_str, $interval_str, $format);
	}

	/**
	 * 日付文字列を受け取り、指定期間前の日付文字列を返す
	 */
	public static function sub($date_str, $interval_str, $format = 'Ymd')
	{
		return static::_calc('sub', $date_str, $interval_str, $format);
	}

	private static function _calc($method, $date_str, $interval_str, $format = 'Ymd')
	{
		$date = new \DateTime($date_str);
		$date->$method(new \DateInterval($interval_str));
		$ret = $date->format($format);
		unset($date);
		return $ret;
	}

	/**
	 * from ～ to に含まれる日付文字列を配列で返す
	 */
	public static function dates_between($from, $to, $format = 'Ymd')
	{
		if ( ! self::is_valid_date($from) or ! self::is_valid_date($to))
		{
			return false;
		}

		$period = new \DatePeriod(
			new \DateTime($from),
			new \DateInterval('P1D'),
			new \DateTime($to.'+1 second') // ～00:00:00だとイテレーション対象とならないんだってさ
			);
		$dates = array();
		foreach ($period as $day)
		{
			$dates[] = $day->format($format);
		}

		unset($period);
		return $dates;
	}

	/**
	 * 満経過年数（年齢など）取得
	 */
	public static function age($from, $to = null)
	{
		if (is_null($to))
		{
			$to = date('Ymd');
		}
		else
		{
			$to = static::format($to, 'Ymd');
		}

		$from = static::format($from, 'Ymd');
		return (int) floor((intval($to) - intval($from)) / 10000);
	}
}
