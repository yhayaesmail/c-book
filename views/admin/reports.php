<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Reports</h1><p>Review bookstore performance and reader activity.</p></section>
<section class="section admin-grid">
    <div class="admin-card glass-card">Books<br><span class="big-number"><?= (int)$overview['books'] ?></span></div>
    <div class="admin-card glass-card">Users<br><span class="big-number"><?= (int)$overview['users'] ?></span></div>
    <div class="admin-card glass-card">Orders<br><span class="big-number"><?= (int)$overview['orders'] ?></span></div>
    <div class="admin-card glass-card">Revenue<br><span class="big-number">$<?= number_format($overview['revenue'], 2) ?></span></div>
</section>
<section class="section">
    <div class="section-head"><h2>Top Reviewed Books</h2></div>
    <div class="table-card glass-card">
        <table class="cart-table">
            <tr><th>Title</th><th>Author</th><th>Genre</th><th>Reviews</th><th>Average</th></tr>
            <?php foreach ($topReviewedBooks as $book): ?>
                <tr><td><?= e($book['title']) ?></td><td><?= e($book['author']) ?></td><td><?= e($book['genre']) ?></td><td><?= (int)$book['review_count'] ?></td><td><?= number_format($book['average_rating'], 1) ?></td></tr>
            <?php endforeach; ?>
        </table>
        <?php if (!$topReviewedBooks): ?><div class="empty-state">No reviews yet.</div><?php endif; ?>
    </div>
</section>
<section class="section">
    <div class="section-head"><h2>Sales by Book</h2></div>
    <div class="table-card glass-card">
        <table class="cart-table">
            <tr><th>Title</th><th>Author</th><th>Genre</th><th>Units</th><th>Total</th></tr>
            <?php foreach ($salesByBook as $book): ?>
                <tr><td><?= e($book['title']) ?></td><td><?= e($book['author']) ?></td><td><?= e($book['genre']) ?></td><td><?= (int)$book['units_sold'] ?></td><td>$<?= number_format($book['sales_total'], 2) ?></td></tr>
            <?php endforeach; ?>
        </table>
        <?php if (!$salesByBook): ?><div class="empty-state">No sales yet.</div><?php endif; ?>
    </div>
</section>
<section class="section">
    <div class="section-head"><h2>Sales by Status</h2></div>
    <div class="table-card glass-card">
        <table class="cart-table">
            <tr><th>Status</th><th>Orders</th><th>Total</th></tr>
            <?php foreach ($salesByStatus as $row): ?>
                <tr><td><?= e($row['status']) ?></td><td><?= (int)$row['order_count'] ?></td><td>$<?= number_format($row['sales_total'], 2) ?></td></tr>
            <?php endforeach; ?>
        </table>
        <?php if (!$salesByStatus): ?><div class="empty-state">No orders yet.</div><?php endif; ?>
    </div>
</section>
<?php require 'views/layouts/footer.php'; ?>
