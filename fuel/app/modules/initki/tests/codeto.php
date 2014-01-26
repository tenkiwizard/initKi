<?php
namespace Initki;

class CodeTo_Liquor extends CodeTo
{
	protected static $list = array(
		'01' => 'gin',
		'02' => 'vodka',
		'03' => 'rum',
		'04' => 'tequila',
		'05' => 'whisky',
	);
}

class CodeTo_Image extends CodeTo
{
	protected static $list = array(
		'01' => array('name' => 'gin', 'icon' => 'image_01.gif'),
		'02' => array('name' => 'vodka', 'icon' => 'image_02.gif'),
		'03' => array('name' => 'rum', 'icon' => 'image_03.gif'),
		);
}

/**
 * CodeTo class Tests
 *
 * @group Modules
 */
class Test_CodeTo extends \TestCase
{
	public function test_get_all()
	{
		$expected = array(
			'01' => 'gin',
			'02' => 'vodka',
			'03' => 'rum',
			'04' => 'tequila',
			'05' => 'whisky',
			);
		$actual = CodeTo_Liquor::get_all();
		$this->assertEquals($expected, $actual);
	}

	public function test_to_name_exists()
	{
		$expected = 'rum';
		$actual = CodeTo_Liquor::to_name('03');
		$this->assertEquals($expected, $actual);

		$actual = CodeTo_Image::to_name('03');
		$this->assertEquals($expected, $actual);
	}

	public function test_to_name_not_exists()
	{
		$this->assertFalse(CodeTo_Liquor::to_name('aaa'));

		$this->assertFalse(CodeTo_Image::to_name('aaa'));
	}

	public function test_from_name_exists()
	{
		$expected = '05';
		$actual = CodeTo_Liquor::from_name('whisky');
		$this->assertEquals($expected, $actual);

		$expected = '03';
		$actual = CodeTo_Image::from_name('rum');
		$this->assertEquals($expected, $actual);
	}

	public function test_from_name_not_exists()
	{
		$this->assertFalse(CodeTo_Liquor::from_name('doburoku'));

		$this->assertFalse(CodeTo_Image::from_name('doburoku'));
	}

	public function test_to_somekey_exists()
	{
		$expected = 'image_03.gif';
		$actual = CodeTo_Image::to_icon('03');
		$this->assertEquals($expected, $actual);
	}

	public function test_to_somekey_not_exists()
	{
		$this->assertFalse(CodeTo_Image::to_icon('00'));
	}

	public function test_to_somekey_invalid_key()
	{
		$this->assertFalse(CodeTo_Image::to_avatar('01'));
	}

	public function test_from_somekey_exists()
	{
		$expected = '03';
		$actual = CodeTo_Image::from_icon('image_03.gif');
		$this->assertEquals($expected, $actual);
	}

	public function test_from_somekey_not_exists()
	{
		$this->assertFalse(CodeTo_Image::from_icon('00'));
	}

	public function test_from_somekey_invalid_key()
	{
		$this->assertFalse(CodeTo_Image::from_avatar('01'));
	}
}
