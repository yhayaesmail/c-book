<?php
require_once 'models/Review.php';
require_once 'models/Order.php';
require_once 'models/Achievement.php';

class ReviewController
{
    private $reviewModel;
    private $orderModel;
    private $achModel;

    public function __construct()
    {
        global $pdo;
        $this->reviewModel = new Review($pdo);
        $this->orderModel = new Order($pdo);
        $this->achModel = new Achievement($pdo);
    }

    public function submit($bookId = null)
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $bookId) {
            if (!$this->orderModel->hasPurchased($_SESSION['user_id'], $bookId)) {
                redirect('books/details/' . (int)$bookId . '?error=notpurchased');
            }
            $this->reviewModel->add($_SESSION['user_id'], $bookId, $_POST['rating'] ?? 5, sanitize($_POST['text'] ?? ''));
            $this->achModel->award($_SESSION['user_id'], 4);
        }
        redirect('books/details/' . (int)$bookId);
    }
}
