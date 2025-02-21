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

$routes->get('/auth/admin/(:alphanum)', [Admin::class, 'role/$1']);

// $routes->get('/produk', [Produk::class, 'index']);
// $routes->get('/produk/detail/(:num)', [Produk::class, 'show/$1'], ['as' => 'product_details']);
// $routes->get('/produk/create', [Produk::class, 'create']);
// $routes->post('/produk/create', [Produk::class, 'store'], ['method' => 'post']);
// $routes->get('/produk/edit/(:num)', [Produk::class, 'edit/$1']);
// $routes->put('/produk/update', [Produk::class, 'update'], ['method' => 'put']);
// $routes->delete('/produk/delete/(:num)', [Produk::class, 'delete/$1'], ['method' => 'delete']);

$routes->resource('produk');
$routes->get('/product/list', [Produk::class, 'productList']);

$routes->get('/pesanan', [Pesanan::class, 'index']);
$routes->get('/pesanan/detail/(:num)', [Pesanan::class, 'detail/$1'], ['as' => 'pesanan_details']);
$routes->get('/pesanan/create', [Pesanan::class, 'create']);
$routes->post('/pesanan/create', [Pesanan::class, 'store']);
$routes->get('/pesanan/update/(:num)', [Pesanan::class, 'editStatus/$1']);
$routes->put('/pesanan/update/(:num)', [Pesanan::class, 'updateStatus/$1']);
$routes->delete('/pesanan/delete/(:num)', [Pesanan::class, 'delete/$1']);

$routes->group('user', function ($routes) {
    $routes->get('dashboard', [User::class, 'index'], ['as' => 'user_dashboard']);
    $routes->get('profile/(:num)', [User::class, 'profile/$1']);
    $routes->get('settings/(:alpha)', [User::class, 'settings/$1']);
});

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', [Admin::class, 'dashboard']);
    $routes->get('user', [Admin::class, 'index']);
});

$routes->group('api', function ($routes) {
    $routes->get('users', [Api::class, 'listUsers']);
    $routes->get('users/(:num)', [Api::class, 'detailUser/$1']);
    $routes->get('products', [Api::class, 'listProducts']);
    $routes->get('products/(:num)', [Api::class, 'detailProduct/$1']);
});

$routes->environment('development', static function ($routes) {
    $routes->get('/test-environtment', function () {
        return "Testing environtment: development";
    });
});

$routes->environment('production', static function ($routes) {
    $routes->get('/test-environtment', function () {
        return "Testing environtment: production";
    });
});

$routes->get('/health-check', function () {
    return 'Server is running...';
});
