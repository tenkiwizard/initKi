<?php

abstract class Database_Query_Builder_Where extends Fuel\Core\Database_Query_Builder_Where
{
	/**
	 * Return up to "LIMIT ..." results
	 *
	 * @param   integer  maximum results to return
	 * @return  $this
	 */
	public function limit($number)
	{
		if (is_null($number))
		{
			$this->_limit = null;
		}
		else
		{
			$this->_limit = (int) $number;
		}

		return $this;
	}
}
