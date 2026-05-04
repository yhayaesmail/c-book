<?php
require_once 'models/Achievement.php';
require_once 'models/Book.php';

class ChallengeController
{
    private $achModel;
    private $bookModel;

    public function __construct()
    {
        global $pdo;
        $this->achModel = new Achievement($pdo);
        $this->bookModel = new Book($pdo);
    }

    public function index()
    {
        requireLogin();
        global $pdo;
        $userId = $_SESSION['user_id'];
        $stmt = $pdo->prepare('SELECT * FROM challenges WHERE user_id = ? AND year = YEAR(CURDATE())');
        $stmt->execute([$userId]);
        $challenge = $stmt->fetch();
        $books = $this->bookModel->getAll();
        $achievements = $this->achModel->getUserAchievements($userId);
        $title = 'Reading Challenge';
        require 'views/clubs/challenges.php';
    }

    public function set()
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $pdo;
            $goal = max(1, (int)($_POST['goal'] ?? 1));
            $userId = $_SESSION['user_id'];
            $year = date('Y');
            $stmt = $pdo->prepare('INSERT INTO challenges (user_id, year, goal) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE goal = ?');
            $stmt->execute([$userId, $year, $goal, $goal]);
            $this->achModel->award($userId, 5);
        }
        redirect('challenges');
    }

    public function addRead()
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $pdo;
            $bookId = (int)($_POST['book_id'] ?? 0);
            $userId = $_SESSION['user_id'];
            $stmt = $pdo->prepare('INSERT INTO reading_log (user_id, book_id) VALUES (?, ?)');
            $stmt->execute([$userId, $bookId]);
            $update = $pdo->prepare('UPDATE challenges SET books_read = books_read + 1 WHERE user_id = ? AND year = YEAR(CURDATE())');
            $update->execute([$userId]);
            $chk = $pdo->prepare('SELECT books_read >= goal AS completed FROM challenges WHERE user_id = ? AND year = YEAR(CURDATE())');
            $chk->execute([$userId]);
            $row = $chk->fetch();
            if ($row && $row['completed']) {
                $pdo->prepare('UPDATE challenges SET completed = 1 WHERE user_id = ? AND year = YEAR(CURDATE())')->execute([$userId]);
                $this->achModel->award($userId, 2);
            }
        }
        redirect('challenges');
    }
}
