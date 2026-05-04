<?php require 'views/layouts/header.php'; ?>
<section class="page-hero compact"><h1>Manage Books</h1></section>
<section class="section admin-layout">
<form class="panel-form glass-card" method="POST"><input type="hidden" name="action" value="add"><input name="title" placeholder="Title" required><input name="author" placeholder="Author" required><input name="genre" placeholder="Genre" required><textarea name="description" placeholder="Description"></textarea><input type="number" step="0.01" name="price" placeholder="Price" required><input name="cover_image" placeholder="Cover image URL or path"><input type="number" name="stock" placeholder="Stock" value="10"><button class="btn">Add Book</button></form>
<div class="table-card glass-card"><table class="cart-table"><tr><th>Title</th><th>Author</th><th>Genre</th><th></th></tr><?php foreach ($books as $b): ?><tr><td><?= e($b['title']) ?></td><td><?= e($b['author']) ?></td><td><?= e($b['genre']) ?></td><td><a class="danger-link" href="<?= url('admin/deleteBook/' . $b['id']) ?>">Delete</a></td></tr><?php endforeach; ?></table></div>
</section>
<?php require 'views/layouts/footer.php'; ?>
