<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact">
    <h1>Browse Books</h1>
    <p>Search by title, author or filter by genre.</p>
</section>
<section class="section browse-layout">
    <aside class="filter-card glass-card">
        <form method="GET" action="<?= url('books/browse') ?>">
            <label>Keyword</label>
            <input name="q" value="<?= e($keyword) ?>" placeholder="Book title or author">
            <label>Genre</label>
            <select name="genre">
                <option value="all">All genres</option>
                <?php foreach ($genres as $g): ?>
                    <option value="<?= e($g) ?>" <?= $genre === $g ? 'selected' : '' ?>><?= e($g) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn" type="submit">Filter</button>
        </form>
    </aside>
    <div class="browse-results">
        <div class="section-head"><h2><?= count($books) ?> Books Found</h2></div>
        <div class="book-grid">
            <?php foreach ($books as $book): ?>
                <?php require 'views/books/partials_card.php'; ?>
            <?php endforeach; ?>
        </div>
        <?php if (!$books): ?><div class="empty-state">No books match your search.</div><?php endif; ?>
    </div>
</section>
<?php require 'views/layouts/footer.php'; ?>
