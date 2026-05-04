<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Admin Dashboard</h1><p>Manage C-Books data.</p></section>
<section class="section admin-grid"><a class="admin-card glass-card" href="<?= url('admin/books') ?>">Manage Books</a><a class="admin-card glass-card" href="<?= url('admin/users') ?>">Manage Users</a><a class="admin-card glass-card" href="<?= url('admin/orders') ?>">Manage Orders</a><a class="admin-card glass-card" href="<?= url('admin/reports') ?>">Reports</a></section>
<?php require 'views/layouts/footer.php'; ?>
