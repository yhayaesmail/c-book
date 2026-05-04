<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Order History</h1><p>Track your previous orders.</p></section>
<section class="section">
    <?php if (!empty($_GET['placed'])): ?><div class="alert success">Order placed successfully.</div><?php endif; ?>
    <div class="table-card glass-card">
        <table class="cart-table">
            <tr><th>ID</th><th>Total</th><th>Status</th><th>Date</th></tr>
            <?php foreach ($orders as $order): ?>
                <tr><td>#<?= (int)$order['id'] ?></td><td>$<?= number_format($order['total'], 2) ?></td><td><span class="status-pill"><?= e($order['status']) ?></span></td><td><?= e($order['created_at']) ?></td></tr>
            <?php endforeach; ?>
        </table>
        <?php if (!$orders): ?><div class="empty-state">No orders yet.</div><?php endif; ?>
    </div>
</section>
<?php require 'views/layouts/footer.php'; ?>
