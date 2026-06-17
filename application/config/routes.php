<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = 'main/notfound';
$route['translate_uri_dashes'] = FALSE;

// Install
$route['install'] = 'install/index';

// Register
$route['register'] = 'register/index';
$route['register/submit'] = 'register/submit';
$route['register/success'] = 'register/success';

// Logs
$route['logs'] = 'logs/index';
$route['logs/get_logs'] = 'logs/get_logs';
$route['logs/stats'] = 'logs/stats';
$route['logs/filters'] = 'logs/filters';
$route['logs/export_csv'] = 'logs/export_csv';
$route['logs/clear_old_logs'] = 'logs/clear_old_logs';

// 404
$route['notfound'] = 'main/notfound';
$route['404'] = 'main/notfound';

// Public tutorial (no login required)
$route['tutorial'] = 'main/tutorial';
$route['tutorial/pembeli'] = 'main/tutorial_pembeli';
$route['tutorial/penjual'] = 'main/tutorial_penjual';

// Owner (Super Admin) - diakses di /owner
$route['owner'] = 'owner/login';
$route['owner/login'] = 'owner/login';
$route['owner/do_login'] = 'owner/do_login';
$route['owner/logout'] = 'owner/logout';
$route['owner/dashboard'] = 'owner/dashboard';
$route['owner/akun'] = 'owner/akun';
$route['owner/update_akun'] = 'owner/update_akun';
$route['owner/toko_list'] = 'owner/toko_list';
$route['owner/toko_save'] = 'owner/toko_save';
$route['owner/toko_get/(:num)'] = 'owner/toko_get/$1';
$route['owner/toko_hapus/(:num)'] = 'owner/toko_hapus/$1';
$route['owner/toko_ajax'] = 'owner/toko_ajax';
$route['owner/order_detail/(:num)'] = 'owner/order_detail/$1';

// Admin Toko - diakses di /admin (session-based, bukan slug)
$route['admin'] = 'admin/index';
$route['admin/login'] = 'admin/index';
$route['admin/do_login'] = 'admin/do_login';
$route['admin/logout'] = 'admin/logout';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/produk'] = 'admin/produk';
$route['admin/orders'] = 'admin/orders';
$route['admin/kategori'] = 'admin/kategori';
$route['admin/pengaturan'] = 'admin/pengaturan';
$route['admin/akun'] = 'admin/akun';
$route['admin/welcome'] = 'admin/welcome';
$route['admin/skip_tour'] = 'admin/skip_tour';
$route['admin/reset_tour'] = 'admin/reset_tour';
$route['admin/update_pengaturan'] = 'admin/update_pengaturan';
$route['admin/update_akun'] = 'admin/update_akun';
$route['admin/produk_save'] = 'admin/produk_save';
$route['admin/produk_get/(:num)'] = 'admin/produk_get/$1';
$route['admin/produk_hapus/(:num)'] = 'admin/produk_hapus/$1';
$route['admin/order_get/(:num)'] = 'admin/order_get/$1';
$route['admin/order_update/(:num)'] = 'admin/order_update/$1';
$route['admin/produk_ajax'] = 'admin/produk_ajax';
$route['admin/orders_ajax'] = 'admin/orders_ajax';
$route['admin/kategori_ajax'] = 'admin/kategori_ajax';
$route['admin/kategori_save'] = 'admin/kategori_save';
$route['admin/kategori_get/(:num)'] = 'admin/kategori_get/$1';
$route['admin/kategori_hapus/(:num)'] = 'admin/kategori_hapus/$1';

// Toko - Halaman User (pelanggan)
// Catch-all di paling bawah - exclude 'admin', 'owner', 'install', 'sas' dan 'index'
// 'sas' = project subfolder (root URL), 'index' = CI default page
$route['(?!admin|owner|install|sas|index|assets|register)([^/]+)'] = 'toko/route/$1';
$route['(?!admin|owner|install|sas|index|assets|register)([^/]+)/user/toko'] = 'toko/order/$1';
$route['(?!admin|owner|install|sas|index|assets|register)([^/]+)/submit_order'] = 'toko/submit_order/$1';
