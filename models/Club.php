<?php
class Club
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($name, $description, $type, $createdBy)
    {
        $stmt = $this->pdo->prepare('INSERT INTO clubs (name, description, type, created_by) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $description, $type, (int)$createdBy]);
    }

    public function getAll()
    {
        return $this->pdo->query('SELECT c.*, u.name AS creator_name FROM clubs c JOIN users u ON c.created_by = u.id ORDER BY c.id DESC')->fetchAll();
    }

    public function getById($clubId)
    {
        $stmt = $this->pdo->prepare('SELECT c.*, u.name AS creator_name FROM clubs c JOIN users u ON c.created_by = u.id WHERE c.id = ?');
        $stmt->execute([(int)$clubId]);
        return $stmt->fetch();
    }

    public function join($clubId, $userId)
    {
        $check = $this->pdo->prepare('SELECT id FROM club_members WHERE club_id = ? AND user_id = ?');
        $check->execute([(int)$clubId, (int)$userId]);
        if (!$check->fetch()) {
            $stmt = $this->pdo->prepare('INSERT INTO club_members (club_id, user_id) VALUES (?, ?)');
            $stmt->execute([(int)$clubId, (int)$userId]);
        }
    }

    public function getMembers($clubId)
    {
        $stmt = $this->pdo->prepare('SELECT u.name FROM club_members cm JOIN users u ON cm.user_id = u.id WHERE cm.club_id = ?');
        $stmt->execute([(int)$clubId]);
        return $stmt->fetchAll();
    }

    public function isMember($clubId, $userId)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM club_members WHERE club_id = ? AND user_id = ?');
        $stmt->execute([(int)$clubId, (int)$userId]);
        return (bool)$stmt->fetch();
    }

    public function getVotes($clubId)
    {
        $stmt = $this->pdo->prepare('SELECT b.title, COUNT(v.id) AS votes FROM votes v JOIN books b ON v.book_id = b.id WHERE v.club_id = ? GROUP BY v.book_id ORDER BY votes DESC');
        $stmt->execute([(int)$clubId]);
        return $stmt->fetchAll();
    }
}
