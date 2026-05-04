<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Checkout</h1><p>Shipping and simulated credit card payment.</p></section>
<section class="section checkout-grid">
    <form class="checkout-card glass-card" method="POST" action="<?= url('orders/place') ?>">
        <h2>Shipping Information</h2>
        <input name="address" placeholder="Address" required>
        <div class="form-row"><input name="city" placeholder="City" required><input name="postal" placeholder="Postal code" required></div>
        <h2>Payment</h2>
        <input name="card_name" placeholder="Name on card" required>
        <input name="card_number" placeholder="Card number" maxlength="19" required>
        <div class="form-row"><input name="expiry" placeholder="MM/YY" required><input name="cvv" placeholder="CVV" maxlength="4" required></div>
        <button class="btn" type="submit">Place Order</button>
    </form>
    <aside class="summary-card glass-card">
        <h2>Order Summary</h2>
        <?php foreach ($items as $item): ?>
            <div class="summary-row"><span><?= e($item['title']) ?> × <?= (int)$item['quantity'] ?></span><strong>$<?= number_format($item['price'] * $item['quantity'], 2) ?></strong></div>
        <?php endforeach; ?>
        <hr>
        <div class="summary-row"><span>Subtotal</span><strong>$<?= number_format($subtotal, 2) ?></strong></div>
        <div class="summary-row"><span>Membership discount</span><strong>-$<?= number_format($discount, 2) ?></strong></div>
        <div class="summary-row total-row"><span>Total</span><strong>$<?= number_format($total, 2) ?></strong></div>
    </aside>
</section>
<?php require 'views/layouts/footer.php'; ?>
