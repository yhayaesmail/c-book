<?php $pageTitle = $title ?? 'C-Books'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
</head>
<body>
<header class="site-header">
    <nav class="navbar">
        <a class="logo" href="<?= url('home') ?>">C-Books</a>
        <div class="nav-search">
            <input id="searchInput" class="search-input" type="search" placeholder="Search books or authors">
            <div id="suggestions" class="suggestions-box"></div>
        </div>
        <button class="menu-toggle" id="menuToggle" type="button">☰</button>
        <div class="nav-links" id="navLinks">
            <a href="<?= url('books/browse') ?>">Browse</a>
            <?php if (isLoggedIn()): ?>
                <a class="rainbow-link" href="<?= url('clubs/list') ?>">Clubs</a>
                <a href="<?= url('challenges') ?>">Challenge</a>
                <a href="<?= url('orders/history') ?>">Orders</a>
                <?php if (isAdmin()): ?><a href="<?= url('admin/dashboard') ?>">Admin</a><?php endif; ?>
                <a class="cart-link" href="<?= url('cart') ?>">Cart <span id="cartCount">0</span></a>
                <a href="<?= url('auth/logout') ?>">Logout</a>
            <?php else: ?>
                <a href="<?= url('auth/login') ?>">Login</a>
                <a class="btn btn-small" href="<?= url('auth/register') ?>">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<main>
<div id="toast" class="toast"></div>
