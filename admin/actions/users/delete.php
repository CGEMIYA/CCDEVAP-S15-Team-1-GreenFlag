<?php

require_once "../../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../users.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: ../../users.php");
    exit();
}

mysqli_begin_transaction($conn);

try {
    $activityStmt = mysqli_prepare($conn, "DELETE FROM activity_logs WHERE user_id = ?");
    mysqli_stmt_bind_param($activityStmt, "i", $id);
    mysqli_stmt_execute($activityStmt);

    $favoritesStmt = mysqli_prepare($conn, "DELETE FROM favorites WHERE user_id = ?");
    mysqli_stmt_bind_param($favoritesStmt, "i", $id);
    mysqli_stmt_execute($favoritesStmt);

    $reviewsStmt = mysqli_prepare($conn, "DELETE FROM reviews WHERE user_id = ?");
    mysqli_stmt_bind_param($reviewsStmt, "i", $id);
    mysqli_stmt_execute($reviewsStmt);

    $announcementsStmt = mysqli_prepare($conn, "DELETE FROM announcements WHERE admin_id = ?");
    mysqli_stmt_bind_param($announcementsStmt, "i", $id);
    mysqli_stmt_execute($announcementsStmt);

    $userStmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($userStmt, "i", $id);
    mysqli_stmt_execute($userStmt);

    mysqli_commit($conn);
} catch (Exception $e) {
    mysqli_rollback($conn);
    throw $e;
}

header("Location: ../../users.php");
exit();

?>
