<?php require 'views/layouts/header.php'; ?>
<section class="auth-shell">
    <form class="auth-form glass-card" method="POST">
        <h1>Create Club</h1>
        <input name="name" placeholder="Club name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <select name="type"><option value="public">Public</option><option value="private">Private</option></select>
        <button class="btn">Create</button>
    </form>
</section>
<?php require 'views/layouts/footer.php'; ?>
