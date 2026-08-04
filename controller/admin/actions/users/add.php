<?php

require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/usermodel.php"; // Loads Model

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/users.php");
    exit();
}

$full_name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$role = $_POST["role"] ?? "student";
$status = $_POST["status"] ?? "pending";

if (empty($full_name) || empty($email) || empty($password)) {
    header("Location: ../../../../view/admin/users.php");
    exit();
}


addUser($conn, $full_name, $email, $password, $role, $status);

/*
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (full_name, email, password, role, status) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $full_name, $email, $hashed_password, $role, $status);
mysqli_stmt_execute($stmt);
*/
header("Location: ../../../../view/admin/users.php");
exit();