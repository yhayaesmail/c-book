<?php require 'views/layouts/header.php'; ?>
<?php $error = $error ?? ''; ?>
<section class="auth-shell">
    <form class="auth-form glass-card" method="POST">
        <h1>Welcome Back</h1>
        <?php if (!empty($_GET['registered'])): ?><div class="alert success">Registration completed. You can login now.</div><?php endif; ?>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn" type="submit">Login</button>
        <p>New here? <a href="<?= url('auth/register') ?>">Create account</a></p>
    </form>
</section>
<?php require 'views/layouts/footer.php'; ?>
