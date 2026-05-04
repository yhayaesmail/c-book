<?php
require_once 'models/Club.php';
require_once 'models/Book.php';
require_once 'models/Achievement.php';
require_once 'models/ReaderSpotlight.php';

class ClubController
{
    private $clubModel;
    private $bookModel;
    private $achModel;
    private $spotlightModel;

    public function __construct()
    {
        global $pdo;
        $this->clubModel = new Club($pdo);
        $this->bookModel = new Book($pdo);
        $this->achModel = new Achievement($pdo);
        $this->spotlightModel = new ReaderSpotlight($pdo);
    }

    public function list()
    {
        requireLogin();
        $clubs = $this->clubModel->getAll();
        $readerOfMonth = $this->spotlightModel->getReaderOfMonth();
        $title = 'Reading Clubs';
        require 'views/clubs/list.php';
    }

    public function create()
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->clubModel->create(sanitize($_POST['name'] ?? ''), sanitize($_POST['description'] ?? ''), sanitize($_POST['type'] ?? 'public'), $_SESSION['user_id']);
            $this->achModel->award($_SESSION['user_id'], 3);
            redirect('clubs/list');
        }
        $title = 'Create Club';
        require 'views/clubs/create.php';
    }

    public function view($clubId = null)
    {
        requireLogin();
        if (!$clubId) {
            show404();
        }
        $club = $this->clubModel->getById($clubId);
        if (!$club) {
            show404();
        }
        $members = $this->clubModel->getMembers($clubId);
        $isMember = $this->clubModel->isMember($clubId, $_SESSION['user_id']);
        $books = $this->bookModel->getAll();
        $votes = $this->clubModel->getVotes($clubId);
        $title = $club['name'];
        require 'views/clubs/view.php';
    }

    public function join($clubId = null)
    {
        requireLogin();
        if ($clubId) {
            $this->clubModel->join($clubId, $_SESSION['user_id']);
            $this->achModel->award($_SESSION['user_id'], 3);
        }
        redirect('clubs/view/' . (int)$clubId);
    }

    public function vote($clubId = null)
    {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $clubId) {
            global $pdo;
            $stmt = $pdo->prepare('INSERT INTO votes (club_id, book_id, user_id) VALUES (?, ?, ?)');
            $stmt->execute([(int)$clubId, (int)($_POST['book_id'] ?? 0), (int)$_SESSION['user_id']]);
        }
        redirect('clubs/view/' . (int)$clubId);
    }
}
