<?php

require __DIR__ . '/vendor/autoload.php';

$request = ['server' => $_SERVER, 'request' => $_REQUEST, 'cookie' => $_COOKIE];

\App\SpringPhp::main($request);