<?php
/**
 * InputFilters
 *
 * @package app
 * @author Kenji Suzuki <https://github.com/kenjis>
 * @license MIT License
 * @copyright 2012 Kenji Suzuki
 * @link https://github.com/kenjis/fuelphp1st/blob/master/sample-code/09/fuel_form/classes/myinputfilters.php
 */

class InputFilters
{
	/**
	 * 文字エンコーディングの検証
	 *
	 * 入力された文字列が期待される文字エンコーディングとして妥当なものかどうか
	 * をチェック、壊れた文字を使うなど不正な文字列があれば攻撃とみなす
	 * @param mixed
	 * @return mixed
	 * @throws \HttpInvalidInputException 不正な入力値
	 */
	public static function check_encoding($value)
	{
		if (is_array($value))
		{
			array_map(array('InputFilters', 'check_encoding'), $value);
			return $value;
		}

		if (mb_check_encoding($value, \Fuel::$encoding))
		{
			return $value;
		}
		else
		{
			static::log_error('Invalid character encoding', $value);
			throw new \HttpInvalidInputException('Invalid input data');
		}
	}

	/**
	 * 制御文字が含まれないかの検証
	 *
	 * 改行とタブ以外の制御文字が入力されていたら攻撃だとみなす
	 * @param mixed
	 * @return mixed
	 * @throws \HttpInvalidInputException 不正な入力値
	 */
	public static function check_control($value)
	{
		if (is_array($value))
		{
			array_map(array('InputFilters', 'check_control'), $value);
			return $value;
		}

		if (preg_match('/\A[\r\n\t[:^cntrl:]]*\z/u', $value) === 1)
		{
			return $value;
		}
		else
		{
			static::log_error('Invalid control characters', $value);
			throw new \HttpInvalidInputException('Invalid input data');
		}
	}

	public static function log_error($msg, $value)
	{
		\Log::error($msg.': '.\Input::uri().' '.urlencode($value).' '.
				   \Input::ip().' "'.\Input::user_agent().'"');
	}
}
