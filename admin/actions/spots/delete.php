<?php
require_once "../../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../spots.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: ../../spots.php");
    exit();
}

mysqli_begin_transaction($conn);
try {
    $spotTagsStmt = mysqli_prepare($conn, "DELETE FROM spot_tags WHERE spot_id = ?");
    mysqli_stmt_bind_param($spotTagsStmt, "i", $id);
    mysqli_stmt_execute($spotTagsStmt);

    $reviewsStmt = mysqli_prepare($conn, "DELETE FROM reviews WHERE spot_id = ?");
    mysqli_stmt_bind_param($reviewsStmt, "i", $id);
    mysqli_stmt_execute($reviewsStmt);

    $spotStmt = mysqli_prepare($conn, "DELETE FROM spots WHERE id = ?");
    mysqli_stmt_bind_param($spotStmt, "i", $id);
    mysqli_stmt_execute($spotStmt);

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    throw $e;
}

header("Location: ../../spots.php");
exit();
