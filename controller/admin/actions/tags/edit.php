<?php
require_once "../../../../view/admin/includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/tags.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$tag_name = trim($_POST["tag_name"] ?? "");

if (!$id || empty($tag_name)) {
    header("Location: ../../../../view/admin/tags.php");
    exit();
}

$stmt = mysqli_prepare($conn, "UPDATE tags SET tag_name = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "si", $tag_name, $id);
mysqli_stmt_execute($stmt);

header("Location: ../../../../view/admin/tags.php");
exit();
