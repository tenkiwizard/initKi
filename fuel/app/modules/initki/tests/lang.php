<?php
namespace Initki;

/**
 * Lang class Tests
 *
 * @group Modules
 */
class Test_Modules extends \TestCase
{
	public function test_detect_order()
	{
		Lang::detect_order();
		$expected = array(
			'ASCII',
			'JIS',
			'UTF-8',
			'EUC-JP',
			'SJIS',
			);
		$actual = mb_detect_order();
		$this->assertEquals($expected, $actual);
	}
}
