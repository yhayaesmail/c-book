<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Reading Clubs</h1><p>Join a community and vote for the next book.</p><a class="btn" href="<?= url('clubs/create') ?>">Create Club</a></section>
<section class="section">
    <div class="glass-card info-panel">
        <div class="section-head"><h2>Reader of the Month</h2></div>
        <?php if ($readerOfMonth): ?>
            <p class="big-number"><?= e($readerOfMonth['name']) ?></p>
            <p class="muted">Monthly score: <?= (int)$readerOfMonth['score'] ?> points</p>
            <div class="summary-row"><span>Reviews</span><strong><?= (int)$readerOfMonth['review_count'] ?></strong></div>
            <div class="summary-row"><span>Orders</span><strong><?= (int)$readerOfMonth['order_count'] ?></strong></div>
            <div class="summary-row"><span>Clubs joined</span><strong><?= (int)$readerOfMonth['club_count'] ?></strong></div>
            <div class="summary-row"><span>Books logged</span><strong><?= (int)$readerOfMonth['read_count'] ?></strong></div>
        <?php else: ?>
            <p class="muted">No monthly activity yet.</p>
        <?php endif; ?>
    </div>
</section>
<section class="section"><div class="club-grid">
<?php foreach ($clubs as $club): ?>
    <article class="club-card glass-card"><span class="genre-pill"><?= e($club['type']) ?></span><h3><?= e($club['name']) ?></h3><p><?= e($club['description']) ?></p><p class="muted">Created by <?= e($club['creator_name']) ?></p><a class="btn btn-small" href="<?= url('clubs/view/' . $club['id']) ?>">Open Club</a></article>
<?php endforeach; ?>
</div></section>
<?php require 'views/layouts/footer.php'; ?>
