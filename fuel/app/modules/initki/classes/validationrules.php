<?php
/**
 * Extended ValidationRules
 *
 * @package app
 * @subpackage initKi
 * @author Kenji Suzuki <https://github.com/kenjis>
 * @author kawamura.hryk
 * @license MIT License
 * @copyright  2012 Kenji Suzuki
 * @link https://github.com/kenjis/fuelphp1st/blob/master/sample-code/09/fuel_form/classes/myvalidationrules.php
 */

namespace Initki;

class ValidationRules
{
	public static function _validation_no_tab_and_newline($value)
	{
		if (preg_match('/\A[^\r\n\t]*\z/u', $value) === 1)
		{
			return true;
		}

		return false;
	}

	public static function _validation_numeric($value)
	{
		return \Validation::_empty($value) || is_numeric($value);
	}

	public static function _validation_in($val, $in)
	{
		$in = explode(':', $in);
		return \Validation::_empty($val) || in_array($val, $in);
	}

	/**
	 * 全角カタカナのみかどうか
	 */
	public static function _validation_fullwidth_katakana($value)
	{
		return \Validation::instance()
			->_validation_match_pattern($value, '/^[ァ-ヶー]+$/u');
	}

	/**
	 * ASCII文字のみかどうか
	 */
	public static function _validation_ascii($value)
	{
		return \Validation::instance()
			->_validation_match_pattern($value, '/^[\x20-\x7f]+$/');
	}

	/**
	 * 日本の郵便番号形式かどうか
	 */
	public static function _validation_jp_postal($value)
	{
		return \Validation::instance()
			->_validation_match_pattern($value, '/^[0-9]{3}-[0-9]{4}$/');
	}

	/**
	 * かなり緩やかな日本国内電話番号
	 */
	public static function _validation_telno($value)
	{
		return \Validation::instance()
			->_validation_match_pattern($value, '/^[0-9]+-[0-9]+-[0-9]{4,}+$/');
	}

	/**
	 * 緩やかなEメールアドレスチェック
	 *
	 * Fuel\Core\Validation::_validation_valid_email()が使っている
	 * PHP\filterval()だと 実在する携帯電話Eメールアドレスが通らない
	 * ケースがあるため（ドット始まりとか）ここでオーバーライド
	 */
	public static function _validation_valid_email($value)
	{
		return \Validation::_empty($value) or 
			preg_match('/^[^@]+@[^@]+\.[^@]+$/', $value);
	}
}
