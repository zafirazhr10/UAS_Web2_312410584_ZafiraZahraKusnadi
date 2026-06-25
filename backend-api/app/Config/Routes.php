<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// Auth routes (excluded from auth filter)
$routes->post('api/register', 'Auth::register');
$routes->post('api/login', 'Auth::login');

// Global CORS preflight catch
$routes->options('(:any)', static function () {});

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    // Protected routes
    $routes->group('kategori', ['filter' => 'jwt'], function($routes) {
        $routes->get('/', 'KategoriController::index');
        $routes->get('(:num)', 'KategoriController::show/$1');
        $routes->post('/', 'KategoriController::create');
        $routes->put('(:num)', 'KategoriController::update/$1');
        $routes->delete('(:num)', 'KategoriController::delete/$1');
    });

    $routes->group('barang', ['filter' => 'jwt'], function($routes) {
        $routes->get('/', 'BarangController::index');
        $routes->get('(:num)', 'BarangController::show/$1');
        $routes->post('/', 'BarangController::create');
        $routes->put('(:num)', 'BarangController::update/$1');
        $routes->delete('(:num)', 'BarangController::delete/$1');
    });
});
