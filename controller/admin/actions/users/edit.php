<?php

require_once "../../../../view/admin/includes/db.php";
require_once "../../../../model/process/usermodel.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../../../view/admin/users.php");
    exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$full_name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$role = $_POST["role"] ?? "student";
//$status = $_POST["status"] ?? "pending";
$password = trim($_POST["password"] ?? "");

if (!$id || empty($full_name) || empty($email)) {
    header("Location: ../../../../view/admin/users.php");
    exit();
}

editUser($conn, $id, $full_name, $email, $password, $role);

/*

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, email = ?, password = ?, role = ?, status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $email, $hashed_password, $role, $status, $id);
} else {
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, email = ?, role = ?, status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $email, $role, $status, $id);
}

mysqli_stmt_execute($stmt);
*/

header("Location: ../../../../view/admin/users.php");
exit();

?>
