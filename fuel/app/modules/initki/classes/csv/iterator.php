<?php
/**
 * Exception(s) thrown from Csv Iterator class
 *
 * @package app
 */

namespace Initki;

class CsvFileAccessException extends \FuelException {}

/**
 * CSV Iterator class
 *
 * @package app
 * @subpackage initKi
 * @author mortanon@gmail.com
 * @author kawamura.hryk
 * @license Creative Commons Attribution 3.0
 * @copyright 1997 - 2013 by the PHP Documentation Group.
 * @link http://php.net/manual/ja/function.fgetcsv.php
 * @link http://www.php.net/manual/ja/copyright.php
 */
class Csv_Iterator implements \Iterator
{
	const ROW_SIZE = 4096;

	/**
	 * The pointer to the cvs file.
	 * @var resource
	 */
	protected $pointer = null;

	/**
	 * The current element, which will
	 * be returned on each iteration.
	 * @var array
	 */
	protected $current = null;

	/**
	 * The row counter.
	 * @var int
	 */
	protected $counter = null;

	/**
	 * The delimiter for the csv file.
	 * @var str
	 */
	protected $delemiter = null;

	/**
	 * Factory method to be callable this class staticly
	 *
	 * @param str $file The csv file.
	 * @param str $delimiter The delimiter.
	 * @retrun Csv_Iterator
	 */
	public static function forge($file, $delimiter = ',')
	{
		return new static($file, $delimiter);
	}

	/**
	 * This is the constructor.It try to open the csv file.The method
	 * throws an exceptionon failure.
	 *
	 * @param str $file The csv file.
	 * @param str $delimiter The delimiter.
	 * @throws CsvIteratorFileAccessException
	 */
	public function __construct($file, $delimiter = ',')
	{
		try
		{
			$this->pointer = fopen($file, 'r');
			$this->delimiter = $delimiter;
		}
		catch (\Exception $e)
		{
			throw new CsvFileAccessException(
				'The file "'.$file.'" cannot be read.');
		}
		$this->rewind();
	}

	/**
	 * This method resets the file pointer.
	 */
	public function rewind()
	{
		$this->counter = 0;
		rewind($this->pointer);
	}

	/**
	 * This method returns the current csv row as a 2 dimensional array
	 *
	 * @return array The current csv row as a 2 dimensional array
	 */
	public function current()
	{
		$this->current = fgetcsv(
			$this->pointer, self::ROW_SIZE, $this->delimiter);
		$this->counter++;
		return $this->current;
	}

	/**
	 * This method returns the current row number.
	 *
	 * @return int The current row number
	 */
	public function key()
	{
		return $this->counter;
	}

	/**
	 * This method checks if the end of file is reached.
	 *
	 * @return boolean Returns true on EOF reached, false otherwise.
	 */
	public function next()
	{
		return ! feof($this->pointer);
	}

	/**
	 * This method checks if the next row is a valid row.
	 *
	 * @return boolean If the next row is a valid row.
	 */
	public function valid()
	{
		if ( ! $this->next())
		{
			fclose($this->pointer);
			$this->pointer = null;
			return false;
		}

		return true;
	}

	/**
	 * Close file pointer if it exists yet
	 */
	public function __destruct()
	{
		if (isset($this->pointer))
		{
			@fclose($this->pointer);
		}
	}
}
