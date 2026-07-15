<?php

require_once "../../includes/db.php";

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];
$status = $_POST['status'];

$sql = "INSERT INTO users
(full_name,email,password,role,status)
VALUES
(?,?,?,?,?)";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $full_name,
    $email,
    $password,
    $role,
    $status
);

mysqli_stmt_execute($stmt);

header("Location: ../../users.php");

exit;