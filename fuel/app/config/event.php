<?php

return array(
	'fuelphp' => array(
		'app_created' => function()
		{
			// FuelPHP 初期化された後の処理
			Initki\Exceptions::register();
			Initki\Lang::detect_order();
		},
		'request_created' => function()
		{
			// Request が作られた後の処理
		},
		'request_started' => function()
		{
			// Request がリクエストされる際の処理
		},
		'controller_started' => function()
		{
			// コントローラーの before() メソッドが呼び出される前の処理
		},
		'controller_finished' => function()
		{
			// コントローラーの after() メソッドが呼び出された後の処理
		},
		'response_created' => function()
		{
			// Response が作られた後の処理
		},
		'request_finished' => function()
		{
			// Request が完了し、レスポンスを受け取った後の処理
		},
		'shutdown' => function()
		{
			// 出力内容が送信され切った後の処理
		},
	),
);
