<?php

use CodeIgniter\Router\RouteCollection;



/**
 * @var RouteCollection $routes
 */

$routes->GET('/', 'Home::index');

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

$routes->GET('client/login', 'Home::index');
$routes->POST('client/login', 'Home::index');
$routes->GET('client/logout', 'Home::index');

$routes->GET('client/compte', 'Compte::index');
$routes->GET('client/depot', 'Compte::depot');
$routes->POST('client/depot', 'Compte::depot');
$routes->GET('client/retrait', 'Compte::retrait');
$routes->POST('client/retrait', 'Compte::retrait');
$routes->GET('client/transfert', 'Compte::transfert');
$routes->POST('client/transfert', 'Compte::transfert');
$routes->GET('client/historique', 'Compte::historique');
