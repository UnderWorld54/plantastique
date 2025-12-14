<?php

use Framework\Application;
use Framework\Database;

$app = new Application();
$router = $app->getRouter();

$router->get('/', 'HomeController@index');

$router->get('/user/{id}', 'UserController@show');
$router->get('/users', 'UserController@list');

$router->get('/plants', 'PlantController@list');
$router->get('/plants/create', 'PlantController@showCreate');
$router->post('/plants/create', 'PlantController@create');
$router->post('/plants/delete/{id}', 'PlantController@delete');

$router->get('/register', 'UserController@showRegister');
$router->post('/register', 'UserController@register');

$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/test-db', function() {
    try {
        $pdo = Database::getConnection();
        return "Connexion à la base de données réussie";
    } catch (\Exception $e) {
        return "Erreur de connexion: " . $e->getMessage();
    }
});

return $app;