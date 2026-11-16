<?php
/**
 * Front Controller — semua request masuk lewat sini.
 * Format URL: index.php?c=<controller>&a=<action>&id=<id>
 */
session_start();

require __DIR__ . '/core/helpers.php';
require __DIR__ . '/core/Database.php';
require __DIR__ . '/core/Model.php';
require __DIR__ . '/core/Controller.php';

$config = require __DIR__ . '/config/config.php';

$c = strtolower(preg_replace('/[^a-z]/i', '', $_GET['c'] ?? $config['default_controller']));
$a = preg_replace('/[^a-zA-Z]/', '', $_GET['a'] ?? $config['default_action']);

$controllerFile = __DIR__ . '/app/controllers/' . ucfirst($c) . 'Controller.php';
if (!is_file($controllerFile)) {
    http_response_code(404);
    die('Halaman tidak ditemukan');
}

// Muat semua model (relasi antar model dipakai lintas controller)
foreach (glob(__DIR__ . '/app/models/*.php') as $m) {
    require_once $m;
}
require $controllerFile;

$class = ucfirst($c) . 'Controller';
$controller = new $class();

if (!is_callable([$controller, $a])) {
    http_response_code(404);
    die('Aksi tidak ditemukan');
}
$controller->$a();
