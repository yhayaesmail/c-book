<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1><?= e($club['name']) ?></h1><p><?= e($club['description']) ?></p><?php if (!$isMember): ?><a class="btn" href="<?= url('clubs/join/' . $club['id']) ?>">Join Club</a><?php endif; ?></section>
<section class="section club-view-grid">
    <div class="glass-card info-panel"><h2>Members</h2><?php foreach ($members as $member): ?><p><?= e($member['name']) ?></p><?php endforeach; ?></div>
    <div class="glass-card info-panel"><h2>Vote Next Book</h2><form method="POST" action="<?= url('clubs/vote/' . $club['id']) ?>"><select name="book_id"><?php foreach ($books as $book): ?><option value="<?= $book['id'] ?>"><?= e($book['title']) ?></option><?php endforeach; ?></select><button class="btn">Vote</button></form></div>
    <div class="glass-card info-panel"><h2>Results</h2><?php foreach ($votes as $vote): ?><div class="summary-row"><span><?= e($vote['title']) ?></span><strong><?= (int)$vote['votes'] ?></strong></div><?php endforeach; ?></div>
</section>
<?php require 'views/layouts/footer.php'; ?>
