<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set('Asia/Jakarta');

if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

require_once 'config/Config.php';
require_once 'helpers/Security.php';
require_once 'helpers/DateHelper.php';
require_once 'controllers/BaseController.php';

// Terapkan session security di setiap request
Security::secureSession();

// HTTP Security Headers — mencegah Clickjacking, XSS via browser, dsb
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Simple Router
$url = isset($_GET['url']) ? $_GET['url'] : 'dashboard';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = 'DashboardController';
$methodName     = 'index';
$params         = [];

// Tentukan controller berdasarkan segmen URL pertama
if (isset($url[0]) && !empty($url[0])) {
    if ($url[0] === 'auth') {
        $controllerName = 'AuthController';
        if (isset($url[1])) $methodName = $url[1];
    } elseif ($url[0] === 'menu') {
        $controllerName = 'MenuController';
        if (isset($url[1])) $methodName = $url[1];
    } elseif ($url[0] === 'report') {
        $controllerName = 'ReportController';
        if (isset($url[1])) $methodName = $url[1];
    } elseif ($url[0] === 'user') {
        $controllerName = 'UserController';
        if (isset($url[1])) $methodName = $url[1];
    } elseif ($url[0] === 'profile') {
        $controllerName = 'ProfileController';
        if (isset($url[1])) $methodName = $url[1];
    } else {
        $controllerName = ucfirst($url[0]) . 'Controller';
    }
}

// Tambahkan parameter id jika ada (sanitasi sebagai integer)
if (isset($_GET['id'])) {
    $params[] = Security::sanitizeInt($_GET['id']);
}

$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        http_response_code(404);
        die('<div style="font-family:sans-serif;padding:30px">Method <b>' . htmlspecialchars($methodName) . '</b> tidak ditemukan.</div>');
    }
} else {
    http_response_code(404);
    die('<div style="font-family:sans-serif;padding:30px">Controller <b>' . htmlspecialchars($controllerName) . '</b> tidak ditemukan.</div>');
}
