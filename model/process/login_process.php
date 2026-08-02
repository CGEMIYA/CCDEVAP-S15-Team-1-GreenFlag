<?php

session_start();

require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: ../../view/login.php");
    exit();

}

$email = trim($_POST["email"]);
$password = $_POST["password"];

if (empty($email) || empty($password)) {

    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: ../../view/login.php");

    exit();

}

$stmt = $pdo->prepare(

    "SELECT * FROM users WHERE email = ?"

);

$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user) {

    $_SESSION["error"] = "Email or password is incorrect.";

    header("Location: ../../view/login.php");

    exit();

}

// OLD CODE
// if (!password_verify($password, $user["password"])) {
//     $_SESSION["error"] = "Email or password is incorrect.";
//     header("Location: ../../view/login.php");
//     exit();
// }

// NEW CODE
$isPasswordCorrect = false;

// Check if the password in the database is a hash (bcrypt hashes always start with $2y$)
if (strpos($user["password"], '$2y$') === 0) {
    $isPasswordCorrect = password_verify($password, $user["password"]);
} else {
    // Fallback for your premade test accounts using plain text
    $isPasswordCorrect = ($password === $user["password"]);
}

if (!$isPasswordCorrect) {
    $_SESSION["error"] = "Email or password is incorrect.";
    header("Location: ../../view/login.php");
    exit();
}
// END OF NEW CODE

if ($user["status"] != "verified") {

    $_SESSION["error"] =
        "Your account is awaiting administrator approval.";

    header("Location: ../../view/login.php");

    exit();

}

$_SESSION["user_id"] = $user["id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];

header("Location: ../../view/index.php");

exit();

?>