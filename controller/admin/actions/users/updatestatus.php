<?php
require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/UserModel.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/users.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$status = trim($_POST["status"] ?? "");

$allowedStatuses = ["pending", "verified", "suspended", "banned"];

if ($id && in_array($status, $allowedStatuses)) {
    updateUserStatus($conn, $id, $status);
}

header("Location: ../../../../view/admin/users.php");
exit();
?>