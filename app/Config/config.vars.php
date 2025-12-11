<?php

date_default_timezone_set('America/Sao_Paulo');
session_start();

$envPath = str_replace('app\\Config','', __DIR__);
$env = parse_ini_file($envPath.'.env');

// URL
define('BASE_URL', 'http://upapp.localhost');

// CONST CHAVE SECRETA JWT
define('SECRET_KEY', $env['JWT_SECRET_KEY']);

// CONST NOME DA SESSION E DO COOKIE
define('COOKIE_NAME','auth-system');

