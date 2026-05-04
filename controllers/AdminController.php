<?php
require_once 'models/Book.php';
require_once 'models/User.php';
require_once 'models/Order.php';
require_once 'models/Report.php';

class AdminController
{
    private $bookModel;
    private $userModel;
    private $orderModel;
    private $reportModel;

    public function __construct()
    {
        requireAdmin();
        global $pdo;
        $this->bookModel = new Book($pdo);
        $this->userModel = new User($pdo);
        $this->orderModel = new Order($pdo);
        $this->reportModel = new Report($pdo);
    }

    public function dashboard()
    {
        $title = 'Admin Dashboard';
        require 'views/admin/dashboard.php';
    }

    public function books()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'add';
            if ($action === 'add') {
                $this->bookModel->create($_POST['title'], $_POST['author'], $_POST['genre'], $_POST['description'], $_POST['price'], $_POST['cover_image'], $_POST['stock']);
            } elseif ($action === 'edit') {
                $this->bookModel->update($_POST['id'], $_POST['title'], $_POST['author'], $_POST['genre'], $_POST['description'], $_POST['price'], $_POST['cover_image'], $_POST['stock']);
            }
            redirect('admin/books');
        }
        $books = $this->bookModel->getAll();
        $title = 'Manage Books';
        require 'views/admin/books.php';
    }

    public function deleteBook($id = null)
    {
        if ($id) {
            $this->bookModel->delete($id);
        }
        redirect('admin/books');
    }

    public function users()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->toggleStatus($_POST['user_id'] ?? 0, $_POST['verified'] ?? 0);
            redirect('admin/users');
        }
        $users = $this->userModel->getAll();
        $title = 'Manage Users';
        require 'views/admin/users.php';
    }

    public function orders()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->orderModel->updateStatus($_POST['order_id'] ?? 0, $_POST['status'] ?? 'pending');
            redirect('admin/orders');
        }
        $orders = $this->orderModel->getAll();
        $title = 'Manage Orders';
        require 'views/admin/orders.php';
    }

    public function reports()
    {
        $overview = $this->reportModel->getOverview();
        $topReviewedBooks = $this->reportModel->getTopReviewedBooks();
        $salesByBook = $this->reportModel->getSalesByBook();
        $salesByStatus = $this->reportModel->getSalesByStatus();
        $title = 'Reports';
        require 'views/admin/reports.php';
    }
}
