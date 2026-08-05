<?php

$host = "localhost";
$dbname = "greenflag";
$username = "root";
$password = "";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );

    // Auto-migrate tables/columns for moderation system
    try {
        $pdo->exec("ALTER TABLE reviews MODIFY status ENUM('pending','approved','rejected','removed') NOT NULL DEFAULT 'approved'");
    } catch (Exception $e) {}

    $cols = [
        "removal_reason VARCHAR(255) DEFAULT NULL",
        "removal_custom_reason TEXT DEFAULT NULL",
        "removed_by INT(11) DEFAULT NULL",
        "removed_at TIMESTAMP NULL DEFAULT NULL"
    ];
    foreach ($cols as $colSql) {
        try {
            $colName = explode(' ', $colSql)[0];
            $stmt = $pdo->query("SHOW COLUMNS FROM reviews LIKE '$colName'");
            if (!$stmt->fetch()) {
                $pdo->exec("ALTER TABLE reviews ADD COLUMN $colSql");
            }
        } catch (Exception $e) {}
    }

    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS review_moderation_logs (
            id INT(11) NOT NULL AUTO_INCREMENT,
            review_id INT(11) NOT NULL,
            admin_id INT(11) NOT NULL,
            reason VARCHAR(255) NOT NULL,
            custom_reason TEXT DEFAULT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_review_mod_review (review_id),
            KEY idx_review_mod_admin (admin_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    } catch (Exception $e) {}

    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INT(11) NOT NULL AUTO_INCREMENT,
            user_id INT(11) NOT NULL,
            review_id INT(11) DEFAULT NULL,
            type VARCHAR(50) NOT NULL DEFAULT 'review_removed',
            message TEXT NOT NULL,
            is_read TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_notifications_user (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    } catch (Exception $e) {}

} catch (PDOException $e) {


    die("Database connection failed: " . $e->getMessage());

}

?>