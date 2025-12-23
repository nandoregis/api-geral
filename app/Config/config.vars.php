<?php

date_default_timezone_set('America/Sao_Paulo');
session_start();

$envPath = str_replace('app\\Config','', __DIR__);
$env = parse_ini_file($envPath.'.env');

// URL
define('BASE_URL', 'http://upapp.localhost');

// CONST CHAVE SECRETA JWT
define('SECRET_KEY', $env['JWT_SECRET_KEY']);
define('EXPIRED_JWT', '+1 minute'); // -> Respeitar regra do Datetime, o modify -> ( +2 minutes, +1 hour, +2 hours , +1 day 2 hours 30 minutes)

// CONST NOME DA SESSION E DO COOKIE
define('COOKIE_NAME','auth-system');

