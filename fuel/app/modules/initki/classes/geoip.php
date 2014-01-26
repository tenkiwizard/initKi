<?php
/**
 * GeoIP Class
 *
 * @package app
 * @subpackage initKi
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Initki;

class Geoip
{
	private static $geoip = null;

	private static $region_to_pref = array(
		'1' => '愛知県',
		'2' => '秋田県',
		'3' => '青森県',
		'4' => '千葉県',
		'5' => '愛媛県',
		'6' => '福井県',
		'7' => '福岡県',
		'8' => '福島県',
		'9' => '岐阜県',
		'10' => '群馬県',
		'11' => '広島県',
		'12' => '北海道',
		'13' => '兵庫県',
		'14' => '茨城県',
		'15' => '石川県',
		'16' => '岩手県',
		'17' => '香川県',
		'18' => '鹿児島県',
		'19' => '神奈川県',
		'20' => '高知県',
		'21' => '熊本県',
		'22' => '京都府',
		'23' => '三重県',
		'24' => '宮城県',
		'25' => '宮崎県',
		'26' => '長野県',
		'27' => '長崎県',
		'28' => '奈良県',
		'29' => '新潟県',
		'30' => '大分県',
		'31' => '岡山県',
		'32' => '大阪府',
		'33' => '佐賀県',
		'34' => '埼玉県',
		'35' => '滋賀県',
		'36' => '島根県',
		'37' => '静岡県',
		'38' => '栃木県',
		'39' => '徳島県',
		'40' => '東京都',
		'41' => '鳥取県',
		'42' => '富山県',
		'43' => '和歌山県',
		'44' => '山形県',
		'45' => '山口県',
		'46' => '山梨県',
		'47' => '沖縄県',
		);

	public static function forge($ip_or_host)
	{
		return new static($ip_or_host);
	}

	public function __construct($ip_or_host)
	{
		try
		{
			static::$geoip = geoip_record_by_name($ip_or_host);
		}
		catch (\Exception $e)
		{
			throw new \RuntimeException();
		}

		static::$geoip['prefecture'] = \Arr::get(
			static::$region_to_pref,
			sprintf('%d', static::$geoip['region']),
			''
			);
	}

	public static function get($key = null)
	{
		if ( ! is_null($key))
		{
			return \Arr::get(static::$geoip, $key, null);
		}

		return static::$geoip;
	}

	public function __get($key)
	{
		return \Arr::get(static::$geoip, $key, null);
	}
}
