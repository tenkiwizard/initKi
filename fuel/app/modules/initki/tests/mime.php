<?php
namespace Initki;

/**
 * Mime class Tests
 *
 * @group Modules
 */
class Test_Mime extends \TestCase
{
	public function test_encode_decode()
	{
		$expected = '【必見】あなたの営業力が256倍アップします！';
		$actual = Mime::decode(Mime::encode($expected));
		$this->assertEquals($expected, $actual);
	}
}
