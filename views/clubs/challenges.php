<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Reading Challenge</h1><p>Set a yearly goal and log finished books.</p></section>
<section class="section challenge-grid">
    <div class="glass-card info-panel"><h2>This Year</h2><?php if ($challenge): ?><p class="big-number"><?= (int)$challenge['books_read'] ?> / <?= (int)$challenge['goal'] ?></p><p><?= $challenge['completed'] ? 'Completed' : 'In progress' ?></p><?php else: ?><p>No challenge yet.</p><?php endif; ?><form method="POST" action="<?= url('challenges/set') ?>"><input type="number" min="1" name="goal" placeholder="Goal" required><button class="btn">Set Goal</button></form></div>
    <div class="glass-card info-panel"><h2>Log Finished Book</h2><form method="POST" action="<?= url('challenges/addRead') ?>"><select name="book_id"><?php foreach ($books as $book): ?><option value="<?= $book['id'] ?>"><?= e($book['title']) ?></option><?php endforeach; ?></select><button class="btn">Add Read</button></form></div>
    <div class="glass-card info-panel"><h2>Achievements</h2><?php foreach ($achievements as $a): ?><span class="achievement-badge"><?= e($a['icon']) ?> <?= e($a['name']) ?></span><?php endforeach; ?></div>
</section>
<?php require 'views/layouts/footer.php'; ?>
