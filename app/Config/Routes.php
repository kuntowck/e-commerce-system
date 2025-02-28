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

$routes->resource('produk');
$routes->get('/product/list', [Produk::class, 'productList']);

$routes->group('pesanan', function ($routes) {
    $routes->get('/', [Pesanan::class, 'index'], ['as' => 'pesanan_list']);
    $routes->get('detail/(:num)', [Pesanan::class, 'detail/$1'], ['as' => 'pesanan_details']);
    $routes->get('create', [Pesanan::class, 'create']);
    $routes->post('create', [Pesanan::class, 'store'], ['method' => 'post']);
    $routes->get('update/(:num)', [Pesanan::class, 'editStatus/$1']);
    $routes->put('update/(:num)', [Pesanan::class, 'updateStatus/$1'], ['method' => 'put']);
    $routes->delete('delete/(:num)', [Pesanan::class, 'delete/$1'], ['method' => 'delete']);
});

$routes->group('user', function ($routes) {
    $routes->get('profile/(:num)', [User::class, 'profile/$1']);
    $routes->get('settings/(:alpha)', [User::class, 'settings/$1']);
});

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', [Admin::class, 'dashboard']);
    $routes->get('user', [User::class, 'index'], ['as' => 'user_list']);
    $routes->get('user/new', [User::class, 'new']);
    $routes->post('user/new', [User::class, 'create'], ['method' => 'post']);
    $routes->get('user/update/(:num)', [User::class, 'edit/$1']);
    $routes->put('user/update/(:num)', [User::class, 'update/$1'], ['method' => 'put']);
    $routes->delete('user/delete/(:num)', [User::class, 'delete/$1'], ['method' => 'delete']);
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
