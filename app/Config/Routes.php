<?php

use CodeIgniter\Router\RouteCollection;



/**
 * @var RouteCollection $routes
 */

$routes->GET('operateur/dashboard', 'Dashboard::index');

$routes->GET('operateur/prefixes', 'Prefixes::index');
$routes->GET('operateur/prefixes/create', 'Prefixes::create');
$routes->POST('operateur/prefixes/create', 'Prefixes::create');
$routes->GET('operateur/prefixes/edit/(:num)', 'Prefixes::edit/$1');
$routes->POST('operateur/prefixes/edit/(:num)', 'Prefixes::edit/$1');
$routes->GET('operateur/prefixes/delete/(:num)', 'Prefixes::delete/$1');

$routes->GET('operateur/types', 'TypesOperation::index');
$routes->GET('operateur/types/baremes', 'TypesOperation::baremes');
$routes->GET('operateur/types/baremes/add', 'TypesOperation::addBareme');
$routes->POST('operateur/types/baremes/add', 'TypesOperation::addBareme');
$routes->GET('operateur/types/baremes/edit/(:num)', 'TypesOperation::editBareme/$1');
$routes->POST('operateur/types/baremes/edit/(:num)', 'TypesOperation::editBareme/$1');
$routes->GET('operateur/types/baremes/delete/(:num)', 'TypesOperation::deleteBareme/$1');

$routes->GET('operateur/comptes', 'Comptes::index');


$routes->GET('client/compte', 'Compte::index');
$routes->GET('client/depot', 'Compte::depot');
$routes->POST('client/depot', 'Compte::depot');
$routes->GET('client/retrait', 'Compte::retrait');
$routes->POST('client/retrait', 'Compte::retrait');
$routes->GET('client/transfert', 'Compte::transfert');
$routes->POST('client/transfert', 'Compte::transfert');
$routes->GET('client/historique', 'Compte::historique');
$routes->match(['GET','POST'], 'client/login', 'Client\Auth::login');
$routes->get('client/logout', 'Client\Auth::logout');
$routes->get('client/compte', 'Client\Compte::index');
$routes->match(['GET','POST'], 'client/depot', 'Client\Compte::depot');
$routes->match(['GET','POST'], 'client/retrait', 'Client\Compte::retrait');
$routes->match(['GET','POST'], 'client/transfert', 'Client\Compte::transfert');
$routes->get('client/historique', 'Client\Compte::historique');

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

$routes->get('historique', 'ClientController::historique');
