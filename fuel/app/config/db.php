<?php

return array(
	'default' => array(
		'type'        => 'pdo',
		'connection'  => array(
			'persistent' => false,
			'compress'   => false,
		),
		'identifier'   => '`',
		'table_prefix' => '',
		'charset'      => 'utf8',
		'enable_cache' => true,
		'profiling'    => false,
	),
);
