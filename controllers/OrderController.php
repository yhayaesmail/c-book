<?php
require_once 'models/Order.php';
require_once 'models/Cart.php';
require_once 'models/Achievement.php';

class OrderController
{
    private $orderModel;
    private $cartModel;
    private $achModel;

    public function __construct()
    {
        global $pdo;
        $this->orderModel = new Order($pdo);
        $this->cartModel = new Cart($pdo);
        $this->achModel = new Achievement($pdo);
    }

    public function checkout()
    {
        requireLogin();
        $items = $this->cartModel->getItems($_SESSION['user_id']);
        if (!$items) {
            redirect('cart');
        }
        $subtotal = 0;
        foreach ($items as $it) {
            $subtotal += $it['price'] * $it['quantity'];
        }
        $discount = 0;
        $membership = $_SESSION['membership_type'] ?? 'none';
        if ($membership === 'premium') {
            $discount = $subtotal * 0.1;
        } elseif ($membership === 'basic') {
            $discount = $subtotal * 0.05;
        }
        $total = $subtotal - $discount;
        $title = 'Checkout';
        require 'views/orders/checkout.php';
    }

    public function place()
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = sanitize(($_POST['address'] ?? '') . ', ' . ($_POST['city'] ?? '') . ' ' . ($_POST['postal'] ?? ''));
            $items = $this->cartModel->getItems($_SESSION['user_id']);
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $discount = 0;
            $membership = $_SESSION['membership_type'] ?? 'none';
            if ($membership === 'premium') {
                $discount = $subtotal * 0.1;
            } elseif ($membership === 'basic') {
                $discount = $subtotal * 0.05;
            }
            $orderId = $this->orderModel->create($_SESSION['user_id'], $subtotal - $discount, $address, $items);
            if ($orderId) {
                $this->cartModel->clear($_SESSION['user_id']);
                $this->achModel->award($_SESSION['user_id'], 1);
                redirect('orders/history?placed=1');
            }
        }
        redirect('cart');
    }

    public function history()
    {
        requireLogin();
        $orders = $this->orderModel->getByUser($_SESSION['user_id']);
        $title = 'Order History';
        require 'views/orders/history.php';
    }
}
