<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Produk;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/produk', [Produk::class, 'index']);
$routes->get('/produk/detail/(:segment)', [Produk::class, 'detail/$1']);
$routes->get('/produk/create', [Produk::class, 'create']);
$routes->post('/produk/craete', [Produk::class, 'store']);
$routes->get('/produk/update/(:segment)', [Produk::class, 'edit/$1']);
$routes->post('/produk/update/(:segment)', [Produk::class, 'update/$1']);
$routes->get('/produk/delete/(:segment)', [Produk::class, 'delete/$1']);

$routes->get('/pesanan', 'Pesanan::index');
$routes->get('/pesanan/detail/(:num)', 'Pesanan::detail/$1');
$routes->get('/pesanan/create', 'Pesanan::create');
$routes->post('/pesanan/create', 'Pesanan::create');
$routes->get('/pesanan/update_status/(:num)', 'Pesanan::updateStatus/$1');
$routes->post('/pesanan/update_status/(:num)', 'Pesanan::updateStatus/$1');
