<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($name, $email, $password)
    {
        $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password, email_verified, verification_token) VALUES (?, ?, ?, 1, NULL)');
        $stmt->execute([$name, $email, $hashed]);
        return true;
    }

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user && password_verify($password, $user['password']) ? $user : false;
    }

    public function verifyEmail($token)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = ?');
        $stmt->execute([$token]);
        return $stmt->rowCount();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, email, role, membership_type, email_verified FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAll()
    {
        return $this->pdo->query('SELECT id, name, email, role, membership_type, email_verified, created_at FROM users ORDER BY created_at DESC')->fetchAll();
    }

    public function toggleStatus($userId, $verified)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET email_verified = ? WHERE id = ?');
        $stmt->execute([(int)$verified, (int)$userId]);
    }
}
