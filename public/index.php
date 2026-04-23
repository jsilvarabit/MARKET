<?php

declare(strict_types=1);

session_start();

$config = require dirname(__DIR__) . '/config/app.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        $controller = new App\Controllers\AuthController($config);
        $controller->login();
        break;

    case 'dashboard':
        $controller = new App\Controllers\AuthController($config);
        $controller->dashboard();
        break;

    case 'logout':
        $controller = new App\Controllers\AuthController($config);
        $controller->logout();
        break;

    default:
        header('Location: index.php?route=login');
        exit;
}
