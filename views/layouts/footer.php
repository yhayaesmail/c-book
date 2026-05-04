</main>
<footer class="footer">
    <div class="footer-grid">
        <div>
            <h3>C-Books</h3>
            <p>A modern bookstore for readers, clubs, reviews and yearly reading challenges.</p>
        </div>
        <div>
            <h4>Explore</h4>
            <a href="<?= url('books/browse') ?>">Browse Books</a>
            <a href="<?= url('clubs/list') ?>">Reading Clubs</a>
            <a href="<?= url('challenges') ?>">Challenge</a>
        </div>
        <div>
            <h4>Account</h4>
            <?php if (isLoggedIn()): ?>
                <a href="<?= url('cart') ?>">Cart</a>
                <a href="<?= url('orders/history') ?>">Orders</a>
            <?php else: ?>
                <a href="<?= url('auth/login') ?>">Login</a>
                <a href="<?= url('auth/register') ?>">Register</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-bottom">© <?= date('Y') ?> C-Books. All rights reserved.</div>
</footer>
<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
