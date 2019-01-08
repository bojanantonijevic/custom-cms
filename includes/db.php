<?php ob_start(); ?>
<?php

$db['db_host'] = "localhost";
$db['db_user'] = "YOUR DB USERNAME";
$db['db_password'] = "YOUR PASSWORD";
$db['db_name'] = "YOUR DB NAME";

foreach($db as $key => $value){
	define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!$connection){
	die();
}