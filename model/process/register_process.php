<?php

session_start();

require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../register.php");
    exit();
}

$full_name = trim($_POST["full_name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if (
    empty($full_name) ||
    empty($email) ||
    empty($password) ||
    empty($confirm_password)
) {
    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: ../register.php");

    exit();
}

if (!str_ends_with($email, "@dlsu.edu.ph")) {
    $_SESSION["error"] = "Only DLSU Emails are allowed!";

    header("Location: ../../view/register.php");

    exit();
}

if ($password !== $confirm_password) {
    $_SESSION["error"] = "Passwords do not match.";

    header("Location: ../../view/register.php");

    exit();
}

$stmt = $pdo->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$stmt->execute([$email]);

if ($stmt->fetch()) {
    $_SESSION["error"] = "An account with this email already exists.";

    header("Location: ../../view/register.php");

    exit();
}

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare(

    "INSERT INTO users
(full_name, email, password, role, status)

VALUES

(?, ?, ?, 'student', 'pending')"

);

$stmt->execute([

    $full_name,
    $email,
    $hashedPassword

]);


$_SESSION["success"] =
    "Registration successful! Your account is now pending administrator approval.";

header("Location:  ../../view/login.php");

exit();

?>