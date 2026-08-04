<?php
require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/tagmodel.php"; // Loads Model

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/tags.php");
    exit();
}

$tag_name = trim($_POST["tag_name"] ?? "");
if (empty($tag_name)) {
    header("Location: ../../../../view/admin/tags.php");
    exit();
}

if (duplicateTag($conn, $tag_name, $id ?? null)) {
    header("Location: ../../../../view/admin/tags.php?error=tag_exists");
    exit();
}

addTag($conn, $tag_name);
/*stmt = mysqli_prepare($conn, "INSERT INTO tags (tag_name) VALUES (?)");
mysqli_stmt_bind_param($stmt, "s", $tag_name);
mysqli_stmt_execute($stmt);*/



header("Location: ../../../../view/admin/tags.php?status=created");
exit();
