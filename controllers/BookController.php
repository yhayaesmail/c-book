<?php
require_once 'models/Book.php';
require_once 'models/Review.php';
require_once 'models/Order.php';

class BookController
{
    private $bookModel;
    private $reviewModel;
    private $orderModel;

    public function __construct()
    {
        global $pdo;
        $this->bookModel = new Book($pdo);
        $this->reviewModel = new Review($pdo);
        $this->orderModel = new Order($pdo);
    }

    public function index()
    {
        $books = $this->bookModel->getAll(12);
        $bestSellers = $this->bookModel->getBestSellers(10);
        $title = 'C-Books';
        require 'views/books/home.php';
    }

    public function browse()
    {
        $keyword = trim($_GET['q'] ?? '');
        $genre = $_GET['genre'] ?? 'all';
        $genres = $this->bookModel->getGenres();
        $books = $this->bookModel->search($keyword, $genre);
        $title = 'Browse Books';
        require 'views/books/browse.php';
    }

    public function details($id = null)
    {
        if (!$id) {
            show404();
        }
        $book = $this->bookModel->getById($id);
        if (!$book) {
            show404();
        }
        $reviews = $this->reviewModel->getByBook($id);
        $avgData = $this->reviewModel->getAverageRating($id);
        $purchased = false;
        $hasReviewed = false;
        if (isLoggedIn()) {
            $purchased = $this->orderModel->hasPurchased($_SESSION['user_id'], $id);
            $hasReviewed = $this->reviewModel->hasReviewed($_SESSION['user_id'], $id);
        }
        $title = $book['title'];
        require 'views/books/details.php';
    }

    public function suggestions()
    {
        header('Content-Type: application/json');
        $term = trim($_GET['term'] ?? '');
        echo json_encode($this->bookModel->getSuggestions($term));
        exit;
    }
}
