<?php
/**
 * Arr class
 *
 * @package  app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Arr
{
	/**
	 * Recursive array_change_key_case
	 * @param array $input
	 * @param integer $case
     * @link http://www.php.net/manual/ja/function.array-change-key-case.php
	 */
	public static function change_key_case(array $input, $case = null)
	{
		if ($case != CASE_UPPER)
		{
			$case = CASE_LOWER;
		}

		$input = array_change_key_case($input, $case);
		foreach ($input as $key => $array)
		{
			if (is_array($array))
			{
				$input[$key] = static::change_key_case($array, $case);
			}
		}

		return $input;
	}
}
