<?php

return array(
	'default' => array(
		//'type' => 'mysqli',
		'type' => 'pdo',
		'connection'  => array(
			//'hostname' => 'localhost', // When ('type' => 'mysqli')
			//'database' => 'initki', // similar to above
			'dsn' => 'mysql:host=localhost;dbname=initki', // When ('type' => 'pdo')
			'username' => 'initki',
			'password'	=> 'initki',
			),
		'profiling' => true,
		),
);
