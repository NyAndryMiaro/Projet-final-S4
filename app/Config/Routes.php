<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('operateur/dashboard', 'Dashboard::index');

$routes->get('operateur/config', 'ConfigOperateur::index');
$routes->post('operateur/config/commission', 'ConfigOperateur::saveCommission');
$routes->post('operateur/config/prefixe/add', 'ConfigOperateur::addPrefixeAutre');
$routes->get('operateur/config/prefixe/delete/(:num)', 'ConfigOperateur::deletePrefixeAutre/$1');


$routes->post('operateur/config-commission', 'Operateur::configCommission');

$routes->get('operateur/prefixes', 'Prefixes::index');
$routes->match(['GET', 'POST'], 'operateur/prefixes/create', 'Prefixes::create');
$routes->match(['GET', 'POST'], 'operateur/prefixes/edit/(:num)', 'Prefixes::edit/$1');
$routes->get('operateur/prefixes/delete/(:num)', 'Prefixes::delete/$1');

$routes->get('operateur/types', 'TypesOperation::index');
$routes->get('operateur/types/baremes', 'TypesOperation::baremes');
$routes->match(['GET', 'POST'], 'operateur/types/baremes/add', 'TypesOperation::addBareme');
$routes->match(['GET', 'POST'], 'operateur/types/baremes/edit/(:num)', 'TypesOperation::editBareme/$1');
$routes->get('operateur/types/baremes/delete/(:num)', 'TypesOperation::deleteBareme/$1');

$routes->get('operateur/comptes', 'Comptes::index');


$routes->get('/', 'Home::index');
$routes->post('/auth/login', 'Home::login');

$routes->get('dashboard', 'ClientController::dashboard');

$routes->get('depot', 'ClientController::depot');
$routes->post('depot', 'ClientController::depot');

$routes->get('retrait', 'ClientController::retrait');
$routes->post('retrait', 'ClientController::retrait');

$routes->get('transfert', 'ClientController::transfert');
$routes->post('transfert', 'ClientController::transfert');

$routes->match(['GET','POST'], 'transfert-multiple', 'ClientController::transfertMultiple');

$routes->match(['GET', 'POST'], 'depot', 'ClientController::depot');
$routes->match(['GET', 'POST'], 'retrait', 'ClientController::retrait');
$routes->match(['GET', 'POST'], 'transfert', 'ClientController::transfert');
$routes->get('historique', 'ClientController::historique');

$routes->match(['GET', 'POST'], 'client/login', 'Client\Auth::login');
$routes->get('client/logout', 'Client\Auth::logout');

$routes->get('/operateur/dim', 'ConfigOperateur::changerDiminuation');
$routes->match(['GET', 'POST'],'/operateur/diminuation', 'ConfigOperateur::updateDiminuation');