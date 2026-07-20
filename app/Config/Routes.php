<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/auth/loginAuto', 'AuthController::loginAuto');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/compte/(:num)/solde', 'OperationController::solde/$1');
$routes->get('/compte/(:num)/depot', 'OperationController::depotForm/$1');
$routes->post('/compte/(:num)/depot', 'OperationController::depot/$1');
$routes->get('/compte/(:num)/retrait', 'OperationController::retraitForm/$1');
$routes->post('/compte/(:num)/retrait', 'OperationController::retrait/$1');
$routes->get('/compte/(:num)/transfert', 'OperationController::transfertForm/$1');
$routes->post('/compte/(:num)/transfert', 'OperationController::transfert/$1');
$routes->get('/compte/(:num)/historique', 'OperationController::historique/$1');

