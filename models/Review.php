<?php
class Review
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function add($userId, $bookId, $rating, $text)
    {
        $rating = min(5, max(1, (int)$rating));
        $stmt = $this->pdo->prepare('INSERT INTO reviews (user_id, book_id, rating, review_text) VALUES (?, ?, ?, ?)');
        $stmt->execute([(int)$userId, (int)$bookId, $rating, $text]);
    }

    public function getByBook($bookId)
    {
        $stmt = $this->pdo->prepare('SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.book_id = ? ORDER BY r.created_at DESC');
        $stmt->execute([(int)$bookId]);
        return $stmt->fetchAll();
    }

    public function getAverageRating($bookId)
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(AVG(rating), 0) AS avg, COUNT(*) AS count FROM reviews WHERE book_id = ?');
        $stmt->execute([(int)$bookId]);
        return $stmt->fetch();
    }

    public function hasReviewed($userId, $bookId)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM reviews WHERE user_id = ? AND book_id = ?');
        $stmt->execute([(int)$userId, (int)$bookId]);
        return (bool)$stmt->fetch();
    }
}
