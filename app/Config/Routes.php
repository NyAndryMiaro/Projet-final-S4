<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('operateur/dashboard', 'Operateur\Dashboard::index');

$routes->get('operateur/prefixes', 'Operateur\Prefixes::index');
$routes->match(['GET','POST'], 'operateur/prefixes/create', 'Operateur\Prefixes::create');
$routes->match(['GET','POST'], 'operateur/prefixes/edit/(:num)', 'Operateur\Prefixes::edit/$1');
$routes->get('operateur/prefixes/delete/(:num)', 'Operateur\Prefixes::delete/$1');

$routes->get('operateur/types', 'Operateur\TypesOperation::index');
$routes->get('operateur/types/baremes', 'Operateur\TypesOperation::baremes');
$routes->match(['GET','POST'], 'operateur/types/baremes/add', 'Operateur\TypesOperation::addBareme');
$routes->match(['GET','POST'], 'operateur/types/baremes/edit/(:num)', 'Operateur\TypesOperation::editBareme/$1');
$routes->get('operateur/types/baremes/delete/(:num)', 'Operateur\TypesOperation::deleteBareme/$1');

$routes->get('operateur/comptes', 'Operateur\Comptes::index');

$routes->match(['GET','POST'], 'client/login', 'Client\Auth::login');
$routes->get('client/logout', 'Client\Auth::logout');
$routes->get('client/compte', 'Client\Compte::index');
$routes->match(['GET','POST'], 'client/depot', 'Client\Compte::depot');
$routes->match(['GET','POST'], 'client/retrait', 'Client\Compte::retrait');
$routes->match(['GET','POST'], 'client/transfert', 'Client\Compte::transfert');
$routes->get('client/historique', 'Client\Compte::historique');

$routes->get('/', 'Home::index');
$routes->post('/auth/login', 'Home::login');