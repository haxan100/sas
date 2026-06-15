<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Environment Configuration
|--------------------------------------------------------------------------
| Auto-detect environment berdasarkan hostname:
| - localhost / 127.0.0.1 → development
| - lainnya → production
|
| Override via .env file: CI_ENV=production
*/

// Load .env if exists (simple parser, no dependencies)
$env_file = FCPATH . '.env';
$env_vars = [];
if (file_exists($env_file)) {
    foreach (file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) continue;
        list($key, $val) = explode('=', $line, 2);
        $env_vars[trim($key)] = trim($val);
    }
}

if (isset($env_vars['CI_ENV'])) {
    $env = $env_vars['CI_ENV'];
} elseif (isset($_SERVER['CI_ENV'])) {
    $env = $_SERVER['CI_ENV'];
} elseif (in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false) {
    $env = 'development';
} else {
    $env = 'production';
}

// Define both CI_ENV (custom) and ENVIRONMENT (CI3 required)
if (!defined('CI_ENV')) define('CI_ENV', $env);
if (!defined('ENVIRONMENT')) define('ENVIRONMENT', $env);

if ($env === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
}
elseif ($env === 'testing') {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', 1);
}
else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

/*
|--------------------------------------------------------------------------
| App-specific config (bisa di-override via .env)
|--------------------------------------------------------------------------
*/
if (isset($env_vars['APP_NAME'])) define('APP_NAME', $env_vars['APP_NAME']); else define('APP_NAME', 'SAS TokoRumah');
if (isset($env_vars['APP_DEBUG'])) define('APP_DEBUG', $env_vars['APP_DEBUG'] === 'true'); else define('APP_DEBUG', $env === 'development');

