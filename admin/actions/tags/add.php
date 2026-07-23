<?php
require_once "../../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../tags.php");
    exit();
}

$tag_name = trim($_POST["tag_name"] ?? "");
if (empty($tag_name)) {
    header("Location: ../../tags.php");
    exit();
}

$stmt = mysqli_prepare($conn, "INSERT INTO tags (tag_name) VALUES (?)");
mysqli_stmt_bind_param($stmt, "s", $tag_name);
mysqli_stmt_execute($stmt);

header("Location: ../../tags.php");
exit();
