<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes Client
$routes->get('/', 'Client\AuthController::login');
$routes->post('/auth/loginAuto', 'Client\AuthController::loginAuto');
$routes->get('/logout', 'Client\AuthController::logout');
$routes->get('/dashboard', 'Client\DashboardController::index');

// Routes Client - Opérations
$routes->group('compte', function ($routes) {
    $routes->get('(:num)/solde', 'Client\OperationController::solde/$1');
    $routes->get('(:num)/depot', 'Client\OperationController::depotForm/$1');
    $routes->post('(:num)/depot', 'Client\OperationController::depot/$1');
    $routes->get('(:num)/retrait', 'Client\OperationController::retraitForm/$1');
    $routes->post('(:num)/retrait', 'Client\OperationController::retrait/$1');
    $routes->get('(:num)/transfert', 'Client\OperationController::transfertForm/$1');
    $routes->post('(:num)/transfert', 'Client\OperationController::transfert/$1');
    $routes->get('(:num)/historique', 'Client\OperationController::historique/$1');
});

// Routes Admin
$routes->group('admin', function ($routes) {
    // Auth Admin
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('auth', 'Admin\Auth::authenticate');
    $routes->get('logout', 'Admin\Auth::logout');
    
    // Dashboard Admin
    $routes->get('/', 'Admin\Dashboard::index');
    
    // Gestion des préfixes
    $routes->get('operateur', 'Admin\Operateur::index');
    $routes->post('operateur/store', 'Admin\Operateur::store');
    $routes->get('operateur/edit/(:num)', 'Admin\Operateur::edit/$1');
    $routes->post('operateur/update/(:num)', 'Admin\Operateur::update/$1');
    $routes->get('operateur/delete/(:num)', 'Admin\Operateur::delete/$1');
    
    // Commissions
    $routes->post('operateur/commission/store', 'Admin\Operateur::storeCommission');
    $routes->get('operateur/commission/delete/(:num)', 'Admin\Operateur::deleteCommission/$1');
    
    // Gestion des opérations
    $routes->get('operation', 'Admin\Operation::index');
    $routes->post('operation/store', 'Admin\Operation::storeOperation');
    $routes->post('operation/tarif', 'Admin\Operation::storeTarif');
    $routes->get('operation/tarif/delete/(:num)', 'Admin\Operation::deleteTarif/$1');
});