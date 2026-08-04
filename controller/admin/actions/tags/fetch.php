<?php
require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/tagmodel.php"; // Loads Model
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    echo json_encode([]);
    exit();
}
$tag= fetchTagById($conn, $id);
echo json_encode($tag ?: []);
/*
$stmt = mysqli_prepare($conn, "SELECT * FROM tags WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
echo json_encode(mysqli_fetch_assoc($result));
*/