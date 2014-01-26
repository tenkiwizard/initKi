<?php
/**
 * Device class Tests
 *
 * @group Modules
 */

namespace Initki;

class Test_Device extends \TestCase
{
	public function test_from_featherphone()
	{
		$data = '一気一憂azAZ09ＡＺ０９アンプゲｱﾝﾌﾟｹﾞ';

		$_SERVER['HTTP_USER_AGENT'] = "xxxxxxxxxxxxxxxxxxxxxxx";
		$expected = '一気一憂azAZ09ＡＺ０９アンプゲｱﾝﾌﾟｹﾞ';
		$actual = Device::from_featurephone($data);
		$this->assertEquals($expected, $actual);

		$_SERVER['HTTP_USER_AGENT'] = 'xxxxxxxxxWILLCOMxxxxxxx';
		$data = mb_convert_encoding(
			$data, Device::FEATUREPHONE_ENCODING, \Fuel::$encoding);
		$expected = '一気一憂azAZ09ＡＺ０９アンプゲｱﾝﾌﾟｹﾞ';
		$actual = Device::from_featurephone($data);
		$this->assertEquals($expected, $actual);
		unset($_SERVER['HTTP_USER_AGENT']);
	}

	public function test_to_featurephone()
	{
		$data = '一気一憂azAZ09ＡＺ０９アンプゲｱﾝﾌﾟｹﾞ';

		$_SERVER['HTTP_USER_AGENT'] = "xxxxxxxxxxxxxxxxxxxxxxx";
		$expected = '一気一憂azAZ09ＡＺ０９アンプゲｱﾝﾌﾟｹﾞ';
		$actual = Device::to_featurephone($data);
		$this->assertEquals($expected, $actual);

		$_SERVER['HTTP_USER_AGENT'] = 'xxxxxxxxxWILLCOMxxxxxxx';
		$expected = mb_convert_encoding(
			'一気一憂azAZ09AZ09ｱﾝﾌﾟｹﾞｱﾝﾌﾟｹﾞ',
			Device::FEATUREPHONE_ENCODING,
			\Fuel::$encoding);
		$actual = Device::to_featurephone($data);
		$this->assertEquals($expected, $actual);
		unset($_SERVER['HTTP_USER_AGENT']);
	}

	public function test_url_session()
	{
		$url = 'http://example.com/a/b/c.php';
		$param = 'x=0&y=1&z=2';
		$tag = '<form  action="'.$url.'">';
		$tag .= '<a href="'.$url.'?'.$param.'">';

		$_SERVER['HTTP_USER_AGENT'] = 'xxxxxxxxxxxxxxxxxxxxxxx';
		$actual = Device::url_session($tag);
		$this->assertEquals($tag, $actual);

		$_SERVER['HTTP_USER_AGENT'] = 'xxxxxxxxxUP.Browserxxxx';
		$expected = '<form  action="'.$url.
			'?'.Session::name().'='.Session::encoded().'">';
		$expected .= '<a href="'.$url.
			'?'.Session::name().'='.Session::encoded().'&'.$param.'">';
		$actual = Device::url_session($tag);
		$this->assertEquals($expected, $actual);

		unset($_SERVER['HTTP_USER_AGENT']);
	}

	/**
	 * @dataProvider featurephone_provider
	 */
	public function test_is_featurephone_valid($data)
	{
		$_SERVER['HTTP_USER_AGENT'] = $data;
		$actual = Device::is_featurephone();
		$expected = true;
		$this->assertEquals($expected, $actual);
		unset($_SERVER['HTTP_USER_AGENT']);
	}

	public function featurephone_provider()
	{
		return array(
			array('xxxxxxxxxUP.Browserxxxx'),
			array('xxxxxxxxxKDDIxxxxxxxxxx'),
			array('xxxxxxxxxDoCoMoxxxxxxxx'),
			array('xxxxxxxxxJ-PHONExxxxxxx'),
			array('xxxxxxxxxVodafonexxxxxx'),
			array('xxxxxxxxxSoftBankxxxxxx'),
			array('xxxxxxxxxMOT-xxxxxxxxxx'),
			array('xxxxxxxxxL-modexxxxxxxx'),
			array('xxxxxxxxxDDIPOCKETxxxxx'),
			array('xxxxxxxxxWILLCOMxxxxxxx'),
			array('xxxxxxxxxPDXGWxxxxxxxxx'),
			array('xxxxxxxxxASTELxxxxxxxxx'),
			array('UP.Browserxxxxxxxxxxxxx'),
			array('KDDIxxxxxxxxxxxxxxxxxxx'),
			array('DoCoMoxxxxxxxxxxxxxxxxx'),
			array('J-PHONExxxxxxxxxxxxxxxx'),
			array('Vodafonexxxxxxxxxxxxxxx'),
			array('SoftBankxxxxxxxxxxxxxxx'),
			array('MOT-xxxxxxxxxxxxxxxxxxx'),
			array('L-modexxxxxxxxxxxxxxxxx'),
			array('DDIPOCKETxxxxxxxxxxxxxx'),
			array('WILLCOMxxxxxxxxxxxxxxxx'),
			array('PDXGWxxxxxxxxxxxxxxxxxx'),
			array('ASTELxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxxxxUP.Browser'),
			array('xxxxxxxxxxxxxxxxxxxKDDI'),
			array('xxxxxxxxxxxxxxxxxDoCoMo'),
			array('xxxxxxxxxxxxxxxxJ-PHONE'),
			array('xxxxxxxxxxxxxxxVodafone'),
			array('xxxxxxxxxxxxxxxSoftBank'),
			array('xxxxxxxxxxxxxxxxxxxMOT-'),
			array('xxxxxxxxxxxxxxxxxL-mode'),
			array('xxxxxxxxxxxxxxDDIPOCKET'),
			array('xxxxxxxxxxxxxxxxWILLCOM'),
			array('xxxxxxxxxxxxxxxxxxPDXGW'),
			array('xxxxxxxxxxxxxxxxxxASTEL'),
		);
	}

	/**
	 * @dataProvider other_ua_provider
	 */
	public function test_is_featurephone_invalid($data)
	{
		$_SERVER['HTTP_USER_AGENT'] = $data;
		$actual = Device::is_featurephone();
		$expected = false;
		$this->assertEquals($expected, $actual);
		unset($_SERVER['HTTP_USER_AGENT']);
	}

	public function other_ua_provider()
	{
		return array(
			array('xxxxxxxxxxxxxxxxxxxxxxx'),
		);
	}

	/**
	 * @dataProvider smartphone_provider
	 */
	public function test_is_smartphone_valid($data)
	{
		$_SERVER['HTTP_USER_AGENT'] = $data;
		$actual = Device::is_smartphone();
		$expected = true;
		$this->assertEquals($expected, $actual);
		unset($_SERVER['HTTP_USER_AGENT']);
	}

	public function smartphone_provider()
	{
		return array(
			array('xxxxxxxxxxiPhonexxxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxiPodxxxxxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxAndroidMobilexxxxxxxxxxxxx'),
			array('xxxxxxxxxxAndroidT hoge tMobilexxxxx'),
			array('xxxxxxxxxxWindowsPhonexxxxxxxxxxxxxx'),
			array('xxxxxxxxxxWindows hoge Phonexxxxxxxx'),
			array('xxxxxxxxxxdreamxxxxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxblackberryxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxCUPCAKExxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxwebOSxxxxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxincognitoxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxwebmatexxxxxxxxxxxxxxxxxxx'),
			array('iPhonexxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('iPodxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('AndroidMobilexxxxxxxxxxxxxxxxxxxxxxx'),
			array('AndroidT hoge tMobilexxxxxxxxxxxxxxx'),
			array('WindowsPhonexxxxxxxxxxxxxxxxxxxxxxxx'),
			array('Windows hoge Phonexxxxxxxxxxxxxxxxxx'),
			array('dreamxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('blackberryxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('CUPCAKExxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('webOSxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('incognitoxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('webmatexxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxiPhone'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxiPodx'),
			array('xxxxxxxxxxxxxxxxxxxxxxxAndroidMobile'),
			array('xxxxxxxxxxxxxxxAndroidT hoge tMobile'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxWindowsPhone'),
			array('xxxxxxxxxxxxxxxxxxWindows hoge Phone'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxdream'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxblackberry'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxCUPCAKE'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxwebOS'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxincognito'),
			array('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxwebmate'),
			);
	}

	/**
	 * @dataProvider other_ua_provider
	 */
	public function test_is_smartphone_invalid($data)
	{
		$_SERVER['HTTP_USER_AGENT'] = $data;
		$actual = Device::is_smartphone();
		$expected = false;
		$this->assertEquals($expected, $actual);
		unset($_SERVER['HTTP_USER_AGENT']);
	}
}
