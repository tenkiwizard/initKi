<?php
namespace Initki;

/**
 * Char class Tests
 *
 * @group Modules
 */
class Test_Char extends \TestCase
{
	public function test_normalize()
	{
		$actual = Char::normalize('ＡＢＹＺａｂｙｚ０１８９ｱｲｦﾝABYZabyz0189あいをんアイヲン');
		$expected = 'ABYZabyz0189アイヲンABYZabyz0189あいをんアイヲン';
		$this->assertEquals($expected, $actual);
	}

	public function test_normalizel()
	{
		$actual = Char::normalizel('ＡＢＹＺａｂｙｚ０１８９ｱｲｦﾝABYZabyz0189あいをんアイヲン');
		$expected = 'abyzabyz0189アイヲンabyzabyz0189あいをんアイヲン';
		$this->assertEquals($expected, $actual);
	}

	public function test_normalizek()
	{
		$actual = Char::normalizek('ＡＢＹＺａｂｙｚ０１８９ｱｲｦﾝABYZabyz0189あいをんアイヲン');
		$expected = 'ABYZabyz0189アイヲンABYZabyz0189アイヲンアイヲン';
		$this->assertEquals($expected, $actual);
	}

	public function test_fullwidth()
	{
		$actual = Char::fullwidth('ＡＢＹＺａｂｙｚ０１８９ｱｲｦﾝABYZabyz0189あいをんアイヲン');
		$expected = 'ＡＢＹＺａｂｙｚ０１８９アイヲンＡＢＹＺａｂｙｚ０１８９あいをんアイヲン';
		$this->assertEquals($expected, $actual);
	}
}
