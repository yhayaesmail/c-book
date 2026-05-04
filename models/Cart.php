<?php
class Cart
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getItems($userId)
    {
        $stmt = $this->pdo->prepare('SELECT c.id AS cart_id, c.quantity, b.* FROM cart_items c JOIN books b ON c.book_id = b.id WHERE c.user_id = ? ORDER BY c.id DESC');
        $stmt->execute([(int)$userId]);
        return $stmt->fetchAll();
    }

    public function getItemCount($userId)
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(SUM(quantity), 0) FROM cart_items WHERE user_id = ?');
        $stmt->execute([(int)$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function add($userId, $bookId, $qty = 1)
    {
        $exist = $this->pdo->prepare('SELECT id FROM cart_items WHERE user_id = ? AND book_id = ?');
        $exist->execute([(int)$userId, (int)$bookId]);
        $item = $exist->fetch();
        if ($item) {
            $stmt = $this->pdo->prepare('UPDATE cart_items SET quantity = quantity + ? WHERE id = ?');
            $stmt->execute([(int)$qty, (int)$item['id']]);
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO cart_items (user_id, book_id, quantity) VALUES (?, ?, ?)');
            $stmt->execute([(int)$userId, (int)$bookId, (int)$qty]);
        }
    }

    public function update($cartId, $quantity, $userId)
    {
        $quantity = max(1, (int)$quantity);
        $stmt = $this->pdo->prepare('UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$quantity, (int)$cartId, (int)$userId]);
    }

    public function remove($cartId, $userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM cart_items WHERE id = ? AND user_id = ?');
        $stmt->execute([(int)$cartId, (int)$userId]);
    }

    public function clear($userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM cart_items WHERE user_id = ?');
        $stmt->execute([(int)$userId]);
    }
}
