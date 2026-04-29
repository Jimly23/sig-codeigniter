<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ── Sekolah (publik) ──────────────────────────────
$routes->get('sekolah',               'Sekolah::index');
$routes->get('sekolah/detail/(:num)', 'Sekolah::detail/$1');

// ── Auth ─────────────────────────────────────────
$routes->get('login',  'Auth::loginPage');
$routes->post('login', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');

// ── Admin ────────────────────────────────────────
$routes->get('admin/dashboard',             'Admin::dashboard');
$routes->get('admin/sekolah',               'Admin::sekolah');
$routes->get('admin/sekolah/tambah',        'Admin::tambah');
$routes->post('admin/sekolah/simpan',       'Admin::simpan');
$routes->get('admin/sekolah/edit/(:num)',   'Admin::edit/$1');
$routes->post('admin/sekolah/update/(:num)','Admin::update/$1');
$routes->post('admin/sekolah/hapus/(:num)', 'Admin::hapus/$1');

// ── Admin Users ──────────────────────────────────
$routes->get('admin/users',              'Admin::users');
$routes->get('admin/users/tambah',       'Admin::tambahUser');
$routes->post('admin/users/simpan',      'Admin::simpanUser');
$routes->post('admin/users/hapus/(:num)','Admin::hapusUser/$1');

// ── API (JSON) ───────────────────────────────────
$routes->get('api/sekolah', 'Api::sekolah');
$routes->post('api/expand-url', 'Api::expandUrl');
