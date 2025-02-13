<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Produk;
use App\Controllers\Pesanan;
use App\Controllers\User;
use App\Controllers\Admin;
use App\Controllers\Api;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', function () {
    return redirect()->to('/');
});
$routes->get('/about', 'Home::about');

$routes->get('/produk', [Produk::class, 'index']);
$routes->get('/produk/detail/(:num)', [Produk::class, 'detail/$1'], ['as' => 'product_details']);
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

$routes->get('/user/dashboard', [User::class, 'index'], ['as' => 'user_dashboard']);
$routes->get('/user/profile/(:num)', [User::class, 'profile/$1']);
$routes->get('/user/settings/(:alpha)', [User::class, 'settings/$1']);
$routes->get('/user/role/(:alphanum)', [User::class, 'role/$1']);

$routes->group('admin', function ($routes) {
    $routes->get('dashboard', [Admin::class, 'dashboard']);
    $routes->get('users', [Admin::class, 'users']);
});

$routes->group('api', function ($routes) {
    $routes->get('users', [Api::class, 'users']);
    $routes->get('products', [Api::class, 'products']);
});
