<?php require 'views/layouts/header.php'; ?>
<?php $error = $error ?? ''; ?>
<section class="auth-shell">
    <form class="auth-form glass-card" method="POST">
        <h1>Create Account</h1>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
        <input type="text" name="name" placeholder="Full name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" minlength="6" required>
        <button class="btn" type="submit">Register</button>
        <p>Already have an account? <a href="<?= url('auth/login') ?>">Login</a></p>
    </form>
</section>
<?php require 'views/layouts/footer.php'; ?>
