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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
];

foreach ($schemaStatements as $statement) {
    mysqli_query($conn, $statement);
}
