<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "greenflag";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

$schemaStatements = [
    "CREATE TABLE IF NOT EXISTS tags (
        id INT(11) NOT NULL AUTO_INCREMENT,
        tag_name VARCHAR(50) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY tag_name (tag_name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS spot_tags (
        spot_id INT(11) NOT NULL,
        tag_id INT(11) NOT NULL,
        PRIMARY KEY (spot_id, tag_id),
        KEY idx_spot_tags_tag_id (tag_id),
        CONSTRAINT fk_spot_tags_spot FOREIGN KEY (spot_id) REFERENCES spots (id) ON DELETE CASCADE,
        CONSTRAINT fk_spot_tags_tag FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS review_moderation_logs (
        id INT(11) NOT NULL AUTO_INCREMENT,
        review_id INT(11) NOT NULL,
        admin_id INT(11) NOT NULL,
        reason VARCHAR(255) NOT NULL,
        custom_reason TEXT DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_review_mod_review (review_id),
        KEY idx_review_mod_admin (admin_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS notifications (
        id INT(11) NOT NULL AUTO_INCREMENT,
        user_id INT(11) NOT NULL,
        review_id INT(11) DEFAULT NULL,
        type VARCHAR(50) NOT NULL DEFAULT 'review_removed',
        message TEXT NOT NULL,
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_notifications_user (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS favorites (
        id INT(11) NOT NULL AUTO_INCREMENT,
        user_id INT(11) NOT NULL,
        spot_id INT(11) NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_fav_user (user_id),
        KEY idx_fav_spot (spot_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
];

foreach ($schemaStatements as $statement) {
    mysqli_query($conn, $statement);
}



// Auto-migrate reviews table for moderation support
@mysqli_query($conn, "ALTER TABLE reviews MODIFY status ENUM('pending','approved','rejected','removed') NOT NULL DEFAULT 'approved'");

$columnsToAdd = [
    "removal_reason" => "VARCHAR(255) DEFAULT NULL",
    "removal_custom_reason" => "TEXT DEFAULT NULL",
    "removed_by" => "INT(11) DEFAULT NULL",
    "removed_at" => "TIMESTAMP NULL DEFAULT NULL"
];
foreach ($columnsToAdd as $colName => $colDef) {
    $checkCol = mysqli_query($conn, "SHOW COLUMNS FROM reviews LIKE '$colName'");
    if ($checkCol && mysqli_num_rows($checkCol) == 0) {
        @mysqli_query($conn, "ALTER TABLE reviews ADD COLUMN $colName $colDef");
    }
}

