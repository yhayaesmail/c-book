<article class="book-card">
    <a href="<?= url('books/details/' . $book['id']) ?>">
        <?php $cover = $book['cover_image'] ? (preg_match('/^(https?:)?\/\//', $book['cover_image']) ? $book['cover_image'] : asset($book['cover_image'])) : asset('images/book-placeholder.svg'); ?>
        <img class="book-cover" src="<?= e($cover) ?>" alt="<?= e($book['title']) ?>">
    </a>
    <div class="book-body">
        <span class="genre-pill"><?= e($book['genre']) ?></span>
        <h3><a href="<?= url('books/details/' . $book['id']) ?>"><?= e($book['title']) ?></a></h3>
        <p><?= e($book['author']) ?></p>
        <div class="book-footer">
            <strong>$<?= number_format($book['price'], 2) ?></strong>
            <?php if (isLoggedIn()): ?>
                <a class="btn btn-small add-to-cart" href="<?= url('cart/add/' . $book['id']) ?>">Add to Cart</a>
            <?php else: ?>
                <a class="btn btn-small" href="<?= url('auth/login') ?>">Login</a>
            <?php endif; ?>
        </div>
    </div>
</article>
