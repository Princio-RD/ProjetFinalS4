<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// Routes Client
// ============================================================
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/auth/loginAuto', 'AuthController::loginAuto');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index');

// ============================================================
// Routes Admin (Opérateur)
// ============================================================
$routes->get('/admin/login', 'Admin\Auth::login');
$routes->post('/admin/auth', 'Admin\Auth::authenticate');
$routes->get('/admin/logout', 'Admin\Auth::logout');

$routes->get('/admin', 'Admin\Dashboard::index');

$routes->get('/admin/operateur', 'Admin\Operateur::index');
$routes->post('/admin/operateur/store', 'Admin\Operateur::store');
$routes->get('/admin/operateur/delete/(:num)', 'Admin\Operateur::delete/$1');

$routes->get('/admin/operation', 'Admin\Operation::index');
$routes->post('/admin/operation/store', 'Admin\Operation::storeOperation');
$routes->post('/admin/operation/tarif', 'Admin\Operation::storeTarif');
$routes->get('/admin/operation/tarif/delete/(:num)', 'Admin\Operation::deleteTarif/$1');