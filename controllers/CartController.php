<?php
require_once 'models/Cart.php';

class CartController
{
    private $cartModel;

    public function __construct()
    {
        global $pdo;
        $this->cartModel = new Cart($pdo);
    }

    public function add($bookId = null)
    {
        if (!isLoggedIn()) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Please login first']);
                exit;
            }
            redirect('auth/login');
        }
        if (!$bookId) {
            show404();
        }
        $this->cartModel->add($_SESSION['user_id'], $bookId);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'count' => $this->cartModel->getItemCount($_SESSION['user_id'])]);
            exit;
        }
        redirect('cart');
    }

    public function index()
    {
        requireLogin();
        $items = $this->cartModel->getItems($_SESSION['user_id']);
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $title = 'Shopping Cart';
        require 'views/cart/index.php';
    }

    public function update()
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (($_POST['qty'] ?? []) as $cartId => $qty) {
                $this->cartModel->update($cartId, $qty, $_SESSION['user_id']);
            }
        }
        redirect('cart');
    }

    public function remove($cartId = null)
    {
        requireLogin();
        if ($cartId) {
            $this->cartModel->remove($cartId, $_SESSION['user_id']);
        }
        redirect('cart');
    }

    public function count()
    {
        header('Content-Type: application/json');
        if (!isLoggedIn()) {
            echo json_encode(['count' => 0]);
            exit;
        }
        echo json_encode(['count' => $this->cartModel->getItemCount($_SESSION['user_id'])]);
        exit;
    }
}
