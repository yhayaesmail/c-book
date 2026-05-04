<?php
class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll($limit = null)
    {
        $sql = 'SELECT * FROM books ORDER BY created_at DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getGenres()
    {
        return $this->pdo->query('SELECT DISTINCT genre FROM books ORDER BY genre')->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM books WHERE id = ?');
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function search($keyword = '', $genre = 'all')
    {
        $sql = 'SELECT * FROM books WHERE 1=1';
        $params = [];
        if ($keyword !== '') {
            $sql .= ' AND (title LIKE ? OR author LIKE ? OR description LIKE ?)';
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
        }
        if ($genre && $genre !== 'all') {
            $sql .= ' AND genre = ?';
            $params[] = $genre;
        }
        $sql .= ' ORDER BY created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getSuggestions($term)
    {
        if (mb_strlen($term) < 2) {
            return [];
        }
        $stmt = $this->pdo->prepare('SELECT id, title, author FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY title LIMIT 8');
        $stmt->execute(['%' . $term . '%', '%' . $term . '%']);
        return $stmt->fetchAll();
    }

    public function create($title, $author, $genre, $description, $price, $cover, $stock)
    {
        $stmt = $this->pdo->prepare('INSERT INTO books (title, author, genre, description, price, cover_image, stock) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $author, $genre, $description, (float)$price, $cover, (int)$stock]);
    }

    public function update($id, $title, $author, $genre, $description, $price, $cover, $stock)
    {
        $stmt = $this->pdo->prepare('UPDATE books SET title = ?, author = ?, genre = ?, description = ?, price = ?, cover_image = ?, stock = ? WHERE id = ?');
        $stmt->execute([$title, $author, $genre, $description, (float)$price, $cover, (int)$stock, (int)$id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM books WHERE id = ?');
        $stmt->execute([(int)$id]);
    }

    public function getBestSellers($limit = 8)
    {
        $sql = 'SELECT b.*, COALESCE(SUM(oi.quantity), 0) AS sold FROM books b LEFT JOIN order_items oi ON b.id = oi.book_id GROUP BY b.id ORDER BY sold DESC, b.created_at DESC LIMIT ' . (int)$limit;
        return $this->pdo->query($sql)->fetchAll();
    }
}
