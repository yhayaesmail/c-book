<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Shopping Cart</h1><p>Review your books before checkout.</p></section>
<section class="section">
    <?php if (!$items): ?>
        <div class="empty-state">Your cart is empty. <a href="<?= url('books/browse') ?>">Browse books</a></div>
    <?php else: ?>
        <form method="POST" action="<?= url('cart/update') ?>" class="cart-panel glass-card">
            <div class="cart-table-wrap">
                <table class="cart-table">
                    <tr><th>Book</th><th>Price</th><th>Qty</th><th>Total</th><th></th></tr>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= e($item['title']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><input class="qty-input" type="number" min="1" name="qty[<?= $item['cart_id'] ?>]" value="<?= (int)$item['quantity'] ?>"></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td><a class="danger-link" href="<?= url('cart/remove/' . $item['cart_id']) ?>">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="cart-actions">
                <strong>Total: $<?= number_format($total, 2) ?></strong>
                <button class="btn btn-light" type="submit">Update Cart</button>
                <a class="btn" href="<?= url('orders/checkout') ?>">Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</section>
<?php require 'views/layouts/footer.php'; ?>
