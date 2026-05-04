<?php require 'views/layouts/header.php'; ?>
<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">Online Bookstore and Reader <span class="rainbow-text">Clubs</span></span>
        <h1>Discover books, join <span class="rainbow-text">Clubs</span>, and build your reading habit.</h1>
        <p>C-Books combines shopping, reviews, achievements and yearly reading challenges in one clean web app.</p>
        <div class="hero-actions">
            <a class="btn" href="<?= url('books/browse') ?>">Browse Books</a>
            <?php if (isLoggedIn()): ?><a class="btn btn-light" href="<?= url('clubs/list') ?>">Explore Clubs</a><?php endif; ?>
        </div>
    </div>
</section>
<section class="section home-section coming-soon-section">
    <div class="section-head">
        <div>
            <span class="section-kicker">Fresh arrivals</span>
            <h2>Coming Soon</h2>
        </div>
        <a href="<?= url('books/browse') ?>">View all</a>
    </div>
    <div class="book-grid featured-grid">
        <?php foreach (array_slice($books, 0, 4) as $book): ?>
            <?php require 'views/books/partials_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>
<section class="section home-section">
    <div class="section-head">
        <div>
            <span class="section-kicker">Reader favorites</span>
            <h2>Top Seller</h2>
        </div>
        <a href="<?= url('books/browse') ?>">Browse more</a>
    </div>
    <div class="book-grid">
        <?php foreach (array_slice($bestSellers, 0, 8) as $book): ?>
            <?php require 'views/books/partials_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>
<section class="section home-section explore-more-section">
    <div class="section-head">
        <div>
            <span class="section-kicker">Keep browsing</span>
            <h2>Explore More</h2>
        </div>
        <a href="<?= url('books/browse') ?>">View all</a>
    </div>
    <div class="explore-slider">
        <div class="slider-track">
            <?php foreach (array_merge($books, $books) as $book): ?>
                <?php require 'views/books/partials_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require 'views/layouts/footer.php'; ?>
