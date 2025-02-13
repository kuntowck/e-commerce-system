<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Produk;
use App\Controllers\Pesanan;
use App\Controllers\User;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', function () {
    return redirect()->to('/');
});
$routes->get('/about', 'Home::about');

$routes->get('/produk', [Produk::class, 'index']);
$routes->get('/produk/detail/(:num)', [Produk::class, 'detail/$1']);
$routes->get('/produk/create', [Produk::class, 'create']);
$routes->post('/produk/create', [Produk::class, 'store']);
$routes->get('/produk/edit/(:num)', [Produk::class, 'edit/$1']);
$routes->put('/produk/update', [Produk::class, 'update']);
$routes->delete('/produk/delete/(:num)', [Produk::class, 'delete/$1']);

$routes->get('/pesanan', [Pesanan::class, 'index']);
$routes->get('/pesanan/detail/(:num)', [Pesanan::class, 'detail/$1']);
$routes->get('/pesanan/create', [Pesanan::class, 'create']);
$routes->post('/pesanan/create', [Pesanan::class, 'store']);
$routes->get('/pesanan/update/(:num)', [Pesanan::class, 'editStatus/$1']);
$routes->post('/pesanan/update/', [Pesanan::class, 'updateStatus']);
$routes->delete('/pesanan/delete/(:num)', [Pesanan::class, 'delete/$1']);
