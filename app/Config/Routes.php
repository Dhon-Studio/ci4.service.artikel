<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('main', 'MainController::create', ['filter' => 'auth']);
$routes->post('main/upload/(:any)', 'MainController::update/$1', ['filter' => 'auth']);
$routes->put('main/(:any)', 'MainController::update/$1', ['filter' => 'auth']);
$routes->delete('main/(:any)', 'MainController::delete/$1', ['filter' => 'auth']);
$routes->resource('main', [
    'controller' => 'MainController',
    'filter' => 'cors'
]);
$routes->options('main', 'MainController::index', ['filter' => 'cors']);
$routes->options('main/(:any)', 'MainController::index', ['filter' => 'cors']);
