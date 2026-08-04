<?php
require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/TagModel.php"; // Loads Model
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/tags.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: ../../../../view/admin/tags.php");
    exit();
}
deleteTag($conn, $id);
/*
mysqli_begin_transaction($conn);
try {
    $spotTagsStmt = mysqli_prepare($conn, "DELETE FROM spot_tags WHERE tag_id = ?");
    mysqli_stmt_bind_param($spotTagsStmt, "i", $id);
    mysqli_stmt_execute($spotTagsStmt);

    $tagStmt = mysqli_prepare($conn, "DELETE FROM tags WHERE id = ?");
    mysqli_stmt_bind_param($tagStmt, "i", $id);
    mysqli_stmt_execute($tagStmt);

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    throw $e;
}
*/
header("Location: ../../../../view/admin/tags.php");
exit();
