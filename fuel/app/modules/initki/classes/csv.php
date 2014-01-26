<?php
/**
 * CSV class
 *   For all people who are not good at using Fuel\Core\Format::_from_csv() like me
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Csv extends Csv_Iterator
{
	/**
	 * External (CSV file) encoding
	 * @var str
	 */
	private $external_encoding = 'UTF-8';

	/**
	 * Set / Get external encoding
	 *
	 * @param str $external_encoding Encoding of CSV file
	 * @return str External encoding of this class
	 */
	public function external_encoding($external_encoding = null)
	{
		if ( ! is_null($external_encoding))
		{
			$this->external_encoding = $external_encoding;
		}

		return $this->external_encoding;
	}

	/**
	 * uses my mb_fgetcsv() method instead of fgetcsv()
	 *
	 * @override
	 * @return array The current csv row as a 2 dimensional array
	 */
	public function current()
	{
		$this->current = static::mb_fgetcsv(
			$this->pointer, self::ROW_SIZE, $this->delimiter);
		if (\Fuel::$encoding != $this->external_encoding)
		{
			mb_convert_variables(
				\Fuel::$encoding,
				$this->external_encoding,
				$this->current);
		}

		$this->counter++;
		return $this->current;
	}

	/**
	 * Shift-JIS encoding support version of PHP internal function fgetcsv()
	 *   Because PHP5 fgetcsv() offten breaks a part of CSV field including Shift-JIS
	 *
	 * @link http://yossy.iimp.jp/wp/?p=56
	 * @license unknown
	 * @param resource handle
	 * @param int length
	 * @param string delimiter
	 * @param string enclosure
	 * @return mixed array fields / bool false when EOF or on error
	 */
	public static function mb_fgetcsv(&$handle, $length = null, $d = ',', $e = '"')
	{
		$d = preg_quote($d);
		$e = preg_quote($e);
		$_line = '';

		$eof = false;
		while ($eof != true)
		{
			$_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
			$itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy_reference);
			if ($itemcnt % 2 == 0) $eof = true;
		}

		$_csv_line = preg_replace('/(?:\r\n|[\r\n])?$/', $d, trim($_line));
		$_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
		preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
		$_csv_data = $_csv_matches[1];
		for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++)
		{
			$_csv_data[$_csv_i] = preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
			$_csv_data[$_csv_i] = str_replace($e.$e, $e, $_csv_data[$_csv_i]);
		}

		return empty($_line) ? false : $_csv_data;
	}
}
