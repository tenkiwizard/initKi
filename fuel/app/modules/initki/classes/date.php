<?php
/**
 * Extended Date class
 *
 * @package  app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Date extends \Date
{
	public function add($sec)
	{
		if ( ! is_int($sec))
		{
			throw new \UnexpectedValueException();
		}

		$this->timestamp += $sec;
		return $this;
	}
}
