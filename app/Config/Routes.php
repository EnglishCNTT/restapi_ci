<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->resource('users', ['controller' => 'UserController']);
    $routes->post('users/upload/(:num)', 'UserController::update/$1');
});
