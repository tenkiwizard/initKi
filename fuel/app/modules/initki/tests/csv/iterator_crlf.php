<?php
namespace Initki;

require_once 'iterator.php';

/**
 * Csv Iterator class Tests (CR+LF newl-ined ver.)
 *
 * @group Modules
 */
class Test_Csv_Iterator_Crlf extends Test_Csv_Iterator
{
	public function setUp()
	{
		$this->file = APPPATH.'modules/initki/tests/fixture/csv/utf8n-crlf.csv';
	}
}
