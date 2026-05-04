<?php
class ReaderSpotlight
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getReaderOfMonth()
    {
        $sql = "
            SELECT
                u.id,
                u.name,
                u.email,
                (
                    COALESCE(r.review_count, 0) * 5 +
                    COALESCE(o.order_count, 0) * 3 +
                    COALESCE(cm.club_count, 0) * 2 +
                    COALESCE(rl.read_count, 0) * 4
                ) AS score,
                COALESCE(r.review_count, 0) AS review_count,
                COALESCE(o.order_count, 0) AS order_count,
                COALESCE(cm.club_count, 0) AS club_count,
                COALESCE(rl.read_count, 0) AS read_count
            FROM users u
            LEFT JOIN (
                SELECT user_id, COUNT(*) AS review_count
                FROM reviews
                WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())
                GROUP BY user_id
            ) r ON u.id = r.user_id
            LEFT JOIN (
                SELECT user_id, COUNT(*) AS order_count
                FROM orders
                WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())
                GROUP BY user_id
            ) o ON u.id = o.user_id
            LEFT JOIN (
                SELECT user_id, COUNT(*) AS club_count
                FROM club_members
                WHERE YEAR(joined_at) = YEAR(CURDATE()) AND MONTH(joined_at) = MONTH(CURDATE())
                GROUP BY user_id
            ) cm ON u.id = cm.user_id
            LEFT JOIN (
                SELECT user_id, COUNT(*) AS read_count
                FROM reading_log
                WHERE YEAR(finished_at) = YEAR(CURDATE()) AND MONTH(finished_at) = MONTH(CURDATE())
                GROUP BY user_id
            ) rl ON u.id = rl.user_id
            WHERE u.role = 'user'
            ORDER BY score DESC, review_count DESC, order_count DESC, u.name ASC
            LIMIT 1
        ";

        $reader = $this->pdo->query($sql)->fetch();
        return $reader && (int)$reader['score'] > 0 ? $reader : null;
    }
}
