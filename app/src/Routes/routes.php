<?php

use Framework\Application;

$app = new Application();
$router = $app->getRouter();

$router->get('/', 'HomeController@index');

$router->get('/user/{id}', 'UserController@show');

return $app;