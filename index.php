<?php
session_start();

require_once 'config/database.php';
require_once 'includes/helpers.php';

$url = $_GET['url'] ?? '';
$url = trim($url, '/');

if ($url === '') {
    $url = 'home';
}

$parts = explode('/', $url);

$controllerKey = $parts[0] ?? 'home';
$action = $parts[1] ?? null;
$params = array_slice($parts, 2);

$routes = [
    'home' => ['BookController', 'index'],
    'books' => ['BookController', $action ?: 'browse'],
    'auth' => ['AuthController', $action ?: 'login'],
    'cart' => ['CartController', $action ?: 'index'],
    'orders' => ['OrderController', $action ?: 'history'],
    'clubs' => ['ClubController', $action ?: 'list'],
    'challenges' => ['ChallengeController', $action ?: 'index'],
    'reviews' => ['ReviewController', $action ?: 'submit'],
    'admin' => ['AdminController', $action ?: 'dashboard'],
    'errors' => ['ErrorController', $action ?: 'notFound']
];

if (!array_key_exists($controllerKey, $routes)) {
    show404();
}

[$controllerName, $method] = $routes[$controllerKey];

$controllerFile = 'controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    show404();
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    show404();
}

$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    show404();
}

call_user_func_array([$controller, $method], $params);
