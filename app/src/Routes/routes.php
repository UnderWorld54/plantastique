<?php

use Framework\Application;
use Framework\Database;

$app = new Application();
$router = $app->getRouter();

$router->get('/', 'HomeController@index');

$router->get('/user/{id}', 'UserController@show');
$router->get('/users', 'UserController@list');

$router->get('/post/{id}', 'PostController@show');
$router->get('/posts', 'PostController@list');

$router->get('/register', 'UserController@showRegister');
$router->post('/register', 'UserController@register');

$router->get('/test-db', function() {
    try {
        $pdo = Database::getConnection();
        return "Connexion à la base de données réussie";
    } catch (\Exception $e) {
        return "Erreur de connexion: " . $e->getMessage();
    }
});

return $app;