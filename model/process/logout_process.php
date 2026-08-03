<?php
// Resume current session so the server knows WHO is asking to log out
session_start();

// Erase all $_SESSION variables (like user_id, email, full_name)
session_unset();

session_destroy();

// user gets brought back to index.php aka homepage
header("Location: ../../view/index.php");
exit();
?>