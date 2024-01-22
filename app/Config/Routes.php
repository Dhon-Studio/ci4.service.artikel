<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->resource('main', [
    'controller' => 'MainController',
    'filter' => 'cors'
]);
$routes->options('main', 'MainController::index', ['filter' => 'cors']);
$routes->options('main/(:any)', 'MainController::index', ['filter' => 'cors']);
