<?php


$envPath = str_replace('app\\Config','', __DIR__);
$env = parse_ini_file($envPath.'.env');

// URL DO SITE 

// CONST BANCO DE DADOS

define('HOST',$env['DB_HOST']);
define('DBNAME', $env['DB_DATABASE']);
define('ROOT', $env['DB_USERNAME']);
define('PASSWORD', $env['DB_PASSWORD']);

define('HOST_AUTH',$env['DB_HOST_AUTH']);
define('DBNAME_AUTH', $env['DB_DATABASE_AUTH']);
define('ROOT_AUTH', $env['DB_USERNAME_AUTH']);
define('PASSWORD_AUTH', $env['DB_PASSWORD_AUTH']);

