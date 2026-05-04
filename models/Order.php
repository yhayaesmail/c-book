<?php
class Order
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($userId, $total, $address, $items)
    {
        if (!$items) {
            return false;
        }
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('INSERT INTO orders (user_id, total, shipping_address, status) VALUES (?, ?, ?, ?)');
            $stmt->execute([(int)$userId, (float)$total, $address, 'pending']);
            $orderId = $this->pdo->lastInsertId();
            $stmtItem = $this->pdo->prepare('INSERT INTO order_items (order_id, book_id, quantity, price_at_time) VALUES (?, ?, ?, ?)');
            $stock = $this->pdo->prepare('UPDATE books SET stock = GREATEST(stock - ?, 0) WHERE id = ?');
            foreach ($items as $item) {
                $stmtItem->execute([$orderId, (int)$item['id'], (int)$item['quantity'], (float)$item['price']]);
                $stock->execute([(int)$item['quantity'], (int)$item['id']]);
            }
            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getByUser($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([(int)$userId]);
        return $stmt->fetchAll();
    }

    public function getAll()
    {
        return $this->pdo->query('SELECT o.*, u.name AS user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC')->fetchAll();
    }

    public function updateStatus($orderId, $status)
    {
        $allowed = ['pending', 'shipped', 'delivered'];
        if (!in_array($status, $allowed, true)) {
            $status = 'pending';
        }
        $stmt = $this->pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$status, (int)$orderId]);
    }

    public function hasPurchased($userId, $bookId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.user_id = ? AND oi.book_id = ? AND o.status != 'pending'");
        $stmt->execute([(int)$userId, (int)$bookId]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
