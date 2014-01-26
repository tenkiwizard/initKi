<?php

return array(
	'language'			 => 'ja', // Default language
	'language_fallback'	 => 'en', // Fallback language when file isn't available for default language
	'locale'			 => null, // PHP set_locale() setting, null to not set

	'default_timezone'	 => 'Asia/Tokyo',

	//'log_threshold'	 => Fuel::L_WARNING,
	'log_threshold'	   => Fuel::L_ALL,
	'security' => array(
		'csrf_autoload'	   => false,
		//'csrf_token_key'	 => 'fuel_csrf_token',
		'csrf_token_key'   => 'csrf_token',
		'csrf_expiration'  => 0,
		'uri_filter'	   => array('htmlentities'),

		'input_filter'	=> array(
			'InputFilters::check_encoding',
			'InputFilters::check_control',
			),
		'output_filter'	 => array(
			'Security::htmlentities',
			//'Initki\\Device::to_featurephone',
			//'Initki\\Device::url_session',
			),
		'htmlentities_flags' => ENT_QUOTES,
		'htmlentities_double_encode' => false,
		'auto_filter_output'  => true,
		'whitelisted_classes' => array(
			'Fuel\\Core\\Response',
			'Fuel\\Core\\View',
			'Fuel\\Core\\ViewModel',
			'Closure',
			'Fuel\\Core\\Validation',
			),
		),
	'always_load' => array(
		'packages' => array(
			'orm',
			),
		'modules' => array(
			'initki',
			'query',
			),
		),
	'module_paths' => array(
		APPPATH.'modules'.DS
		),
);
