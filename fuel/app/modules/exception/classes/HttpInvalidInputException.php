<?php

/**
 * HTTP Invalid input exception <<VS. malicious attack>>
 *
 * @package app
 * @author Kenji Suzuki <https://github.com/kenjis>
 * @author kawamura.hryk
 * @license MIT License
 * @copyright 2012 Kenji Suzuki
 * @link https://github.com/kenjis/fuelphp1st/blob/master/sample-code/09/fuel_form/classes/httpinvalidinputexception.php
 */
class HttpInvalidInputException extends HttpException
{
	protected static $data = array(
		'message' => 'Invalid Input',
		);
}
