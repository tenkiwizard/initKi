<?php
namespace Initki;

/**
 * GeoIP class Tests
 *
 * @group Modules
 */
class Test_Geoip extends \TestCase
{
	public function test_not_exists_host()
	{
		$this->setExpectedException('\RuntimeException');
		Geoip::forge('192.168.0.1');
	}

	public function test_get()
	{
		$host = 'small-social-coding.org';
		$array = Geoip::forge($host)->get();
		$this->assertEquals('JP', $array['country_code']);

		$this->assertEquals('JP', Geoip::forge($host)->get('country_code'));
	}

	public function test_as_object()
	{
		$host = 'small-social-coding.org';
		$this->assertEquals('JP', Geoip::forge($host)->country_code);

		$geoip = Geoip::forge($host);
		$this->assertEquals('JP', $geoip->country_code);
	}

	public function test_prefecture()
	{
		$host = 'small-social-coding.org';
		$this->assertEquals('千葉県', Geoip::forge($host)->prefecture);
	}
}
