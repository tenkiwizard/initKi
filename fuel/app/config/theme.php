<?php
$active = 'default';
/*
if (Initki\Device::is_featurephone())
{
	$active = 'fp';
}
*/

/*
if (Initki\Device::is_smartphone())
{
	$active = 'sp';
}
*/

return array(
	'active' => $active,
	'fallback' => 'default',
	'paths' => array(
		APPPATH.'themes',
	),
	'assets_folder' => 'assets',
	'view_ext' => '.php',
	'require_info_file' => false,
	'info_file_name' => 'themeinfo.php',
	'use_modules' => false,
);
