<?php
class Report
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getOverview()
    {
        return [
            'books' => (int)$this->pdo->query('SELECT COUNT(*) FROM books')->fetchColumn(),
            'users' => (int)$this->pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'orders' => (int)$this->pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
            'revenue' => (float)$this->pdo->query('SELECT COALESCE(SUM(total), 0) FROM orders')->fetchColumn()
        ];
    }

    public function getTopReviewedBooks($limit = 10)
    {
        $sql = "
            SELECT
                b.title,
                b.author,
                b.genre,
                COUNT(r.id) AS review_count,
                COALESCE(AVG(r.rating), 0) AS average_rating
            FROM books b
            LEFT JOIN reviews r ON b.id = r.book_id
            GROUP BY b.id
            HAVING review_count > 0
            ORDER BY review_count DESC, average_rating DESC, b.title ASC
            LIMIT " . (int)$limit;

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getSalesByBook($limit = 10)
    {
        $sql = "
            SELECT
                b.title,
                b.author,
                b.genre,
                COALESCE(SUM(oi.quantity), 0) AS units_sold,
                COALESCE(SUM(oi.quantity * oi.price_at_time), 0) AS sales_total
            FROM books b
            LEFT JOIN order_items oi ON b.id = oi.book_id
            GROUP BY b.id
            HAVING units_sold > 0
            ORDER BY units_sold DESC, sales_total DESC, b.title ASC
            LIMIT " . (int)$limit;

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getSalesByStatus()
    {
        return $this->pdo->query("
            SELECT status, COUNT(*) AS order_count, COALESCE(SUM(total), 0) AS sales_total
            FROM orders
            GROUP BY status
            ORDER BY sales_total DESC
        ")->fetchAll();
    }
}
