<?php

	ini_set('error_reporting', E_ALL);

	include_once(__DIR__.'/dinky_app.php');

	$app = new dinky_app();
	$app->run();
