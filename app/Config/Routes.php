<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);

$routes->get('/', 'Home::index');
$routes->get('/account', 'Account::index');
$routes->get('/checkout', 'Checkout::index');
$routes->get('/view/(:any)', 'View::index/$1');
$routes->get('/view/code/(:any)', 'View::code/$1');
$routes->get('/payment', 'Payment::index');

$routes->get('/en', 'Home::index/en');
$routes->get('/pt', 'Home::index/pt');
$routes->get('/es', 'Home::index/es');