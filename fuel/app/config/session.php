<?php

return array(
	'auto_initialize' => true,
	//'driver' => 'memcached',
	'driver' => 'file',
	'match_ip' => false,
	'match_ua' => true,
	'expiration_time' => 7200,
	'flash_id' => 'flash',
	// for requests that don't support cookies (i.e. flash), use this POST variable to pass the cookie to the session driver
	'post_cookie_name' => '',
	//'encrypt_cookie' => false,

	'file' => array(
		'cookie_name' => 'initkisessf',
		'path' => '/tmp',
		'gc_probability' => 5, // probability % (between 0 and 100) for garbage collection
		),

	'memcached' => array(
		'cookie_name' => 'initkisessm',
		'servers' => array(
			'default' => array(
				'host' => '127.0.0.1',
				'port' => 11211,
				'weight' => 100
				),
			),
		),
);
