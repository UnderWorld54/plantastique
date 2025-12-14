<?php

require_once __DIR__ . '/../vendor/autoload.php';

Framework\Env::load(__DIR__ . '/../.env');
Framework\Session::start();

$app = require_once __DIR__ . '/../src/Routes/routes.php';

$app->run();
