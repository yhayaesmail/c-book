<?php
function sanitize($data)
{
    return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
}

function e($data)
{
    return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
}

function redirect($url = '')
{
    header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
    exit;
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        redirect('auth/login');
    }
}

function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        redirect('errors/403');
    }
}

function show404()
{
    http_response_code(404);
    $title = 'Page Not Found';
    require 'views/errors/404.php';
    exit;
}

function asset($path)
{
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

function url($path = '')
{
    return BASE_URL . '/' . ltrim($path, '/');
}
