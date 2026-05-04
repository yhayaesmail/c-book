<?php require 'views/layouts/header.php'; ?>
<link rel="stylesheet" href="<?= asset('css/book-details.css') ?>">
<section class="section details-grid">
    <?php $cover = $book['cover_image'] ? (preg_match('/^(https?:)?\/\//', $book['cover_image']) ? $book['cover_image'] : asset($book['cover_image'])) : asset('images/book-placeholder.svg'); ?>
    <div class="details-cover glass-card"><img src="<?= e($cover) ?>" alt="<?= e($book['title']) ?>"></div>
    <div class="details-info">
        <span class="genre-pill"><?= e($book['genre']) ?></span>
        <h1><?= e($book['title']) ?></h1>
        <p class="muted">by <?= e($book['author']) ?></p>
        <div class="rating">Rating: <?= number_format($avgData['avg'], 1) ?> / 5 from <?= (int)$avgData['count'] ?> reviews</div>
        <h2>$<?= number_format($book['price'], 2) ?></h2>
        <?php if (isLoggedIn()): ?>
            <a class="btn add-to-cart" href="<?= url('cart/add/' . $book['id']) ?>">Add to Cart</a>
        <?php else: ?>
            <a class="btn" href="<?= url('auth/login') ?>">Login to buy</a>
        <?php endif; ?>
    </div>
</section>
<section class="section book-details-section">
    <div class="details-summary glass-card">
        <div class="section-head"><h2>Details</h2></div>
        <p><?= e($book['description'] ?: 'A carefully selected book with a strong voice, clear themes, and a story worth exploring.') ?></p>
    </div>
</section>
<section class="section">
    <div class="section-head"><h2>Reviews</h2></div>
    <?php if (isset($_GET['error'])): ?><div class="alert error">You can review only books you have purchased.</div><?php endif; ?>
    <?php if ($purchased && !$hasReviewed): ?>
        <form class="panel-form" method="POST" action="<?= url('reviews/submit/' . $book['id']) ?>">
            <select name="rating"><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option></select>
            <textarea name="text" placeholder="Write your review" required></textarea>
            <button class="btn">Submit Review</button>
        </form>
    <?php endif; ?>
    <div class="review-list">
        <?php foreach ($reviews as $review): ?>
            <div class="review-card glass-card"><strong><?= e($review['name']) ?></strong><span><?= (int)$review['rating'] ?>/5</span><p><?= e($review['review_text']) ?></p></div>
        <?php endforeach; ?>
        <?php if (!$reviews): ?><div class="empty-state">No reviews yet.</div><?php endif; ?>
    </div>
</section>
<?php require 'views/layouts/footer.php'; ?>
