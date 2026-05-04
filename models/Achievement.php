<?php
class Achievement
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function award($userId, $achievementId)
    {
        $check = $this->pdo->prepare('SELECT id FROM user_achievements WHERE user_id = ? AND achievement_id = ?');
        $check->execute([(int)$userId, (int)$achievementId]);
        if (!$check->fetch()) {
            $stmt = $this->pdo->prepare('INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, ?)');
            $stmt->execute([(int)$userId, (int)$achievementId]);
        }
    }

    public function getUserAchievements($userId)
    {
        $stmt = $this->pdo->prepare('SELECT a.name, a.icon FROM user_achievements ua JOIN achievements a ON ua.achievement_id = a.id WHERE ua.user_id = ?');
        $stmt->execute([(int)$userId]);
        return $stmt->fetchAll();
    }
}
