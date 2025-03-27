<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pesanan;
use App\Controllers\Api;
use App\Controllers\Produk;
use App\Controllers\User;
use App\Controllers\Admin;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', function () {
    return redirect()->to('/');
});

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('register', 'Auth::register', ['as' => 'register']);
    $routes->post('register', 'Auth::attemptRegister');

    $routes->get('login', 'Auth::login', ['as' => 'login']);
    $routes->post('login', 'Auth::attemptLogin');
});

// $routes->resource('produk');

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin::index');
    $routes->get('/', function () {
        return redirect()->to('admin/dashboard');
    });
});

$routes->group('product-manager', ['filter' => 'role:product-manager'], function ($routes) {
    $routes->get('dashboard', 'Produk::dashboard');
    $routes->get('/', function () {
        return redirect()->to('product-manager/dashboard');
    });
});

$routes->group('customer', ['filter' => 'role:customer'], function ($routes) {
    $routes->get('dashboard', 'Home::dashboardCustomer');
    $routes->get('/', function () {
        return redirect()->to('customer/dashboard');
    });
});

$routes->group('admin/users', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('new', 'User::new');
    $routes->post('new', 'User::create');
    $routes->get('detail/(:num)', 'User::profile/$1');
    $routes->get('update/(:num)', 'User::edit/$1');
    $routes->put('update/(:num)', 'User::update/$1');
    $routes->delete('delete/(:num)', 'User::delete/$1');
});

$routes->group('admin/roles', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Role::index');
    $routes->get('new', 'Role::new');
    $routes->post('new', 'Role::create');
    $routes->get('detail/(:num)', 'Role::show/$1');
    $routes->get('update/(:num)', 'Role::edit/$1');
    $routes->put('update/(:num)', 'Role::update/$1');
    $routes->delete('delete/(:num)', 'Role::delete/$1');
});

$routes->group('product-manager/products', ['filter' => 'role:product-manager,admin'], function ($routes) {
    $routes->get('/', 'Produk::index');
    $routes->get('(:num)/show', 'Produk::show/$1');
    $routes->get('new', 'Produk::new');
    $routes->post('new', 'Produk::create');
    $routes->get('(:num)/edit', 'Produk::edit/$1');
    $routes->put('(:num)/update', 'Produk::update/$1');
    $routes->delete('(:num)/delete', 'Produk::delete/$1');
    $routes->get('report', 'Produk::productReportForm');
    $routes->get('report-excel', 'Produk::productReportExcel');
});

$routes->group('product-manager/orders', ['filter' => 'role:product-manager,admin'], function ($routes) {
    $routes->get('/', [Pesanan::class, 'index'], ['as' => 'pesanan_list']);
    $routes->get('detail/(:num)', [Pesanan::class, 'detail/$1'], ['as' => 'pesanan_details']);
    $routes->get('update/(:num)', [Pesanan::class, 'editStatus/$1']);
    $routes->put('update/(:num)', [Pesanan::class, 'updateStatus/$1'], ['method' => 'put']);
    $routes->delete('delete/(:num)', [Pesanan::class, 'delete/$1'], ['method' => 'delete']);
});

$routes->group('customer', ['filter' => 'role:customer,admin'], function ($routes) {
    $routes->get('profile/(:num)', 'User::profile/$1');
    $routes->get('catalog', 'Produk::productList');
    $routes->get('cart', 'Pesanan::create');
    $routes->post('cart', 'Pesanan::store');
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
