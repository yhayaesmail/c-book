<?php

require_once __DIR__ . '/config/database.php';

function ask($label)
{
    echo $label . ': ';
    return trim(fgets(STDIN));
}

$name = ask('Username');
$email = ask('Email');
$password = ask('Password');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
    echo "Invalid data. Password must be at least 6 characters.\n";
    exit(1);
}

$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    $stmt = $pdo->prepare('UPDATE users SET name = ?, password = ?, role = ?, email_verified = 1, verification_token = NULL WHERE email = ?');
    $stmt->execute([$name, $hashed, 'admin', $email]);
    echo "Existing user promoted to admin.\n";
} else {
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, role, membership_type, email_verified, verification_token) VALUES (?, ?, ?, ?, ?, 1, NULL)');
    $stmt->execute([$name, $email, $hashed, 'admin', 'premium']);
    echo "Admin user created successfully.\n";
}
