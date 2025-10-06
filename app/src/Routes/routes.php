<?php

use Framework\Application;

$app = new Application();
$router = $app->getRouter();

$router->get('/', 'HomeController@index');

$router->get('/user/{id}', 'UserController@show');
$router->get('/users', 'UserController@list');

$router->get('/post/{id}', 'PostController@show');
$router->get('/posts', 'PostController@list');

return $app;