<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Green Flag</title>

    <link rel="stylesheet" href="../css/global.css">

    <link rel="stylesheet" href="../css/auth.css">

    <link rel="stylesheet" href="../css/responsive.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

    <header>

        <div class="left-nav">

            <button class="menu-btn" onclick="window.location.href='../index.php'">

                <i class="fa-solid fa-arrow-left"></i>

            </button>

            <h1 class="logo">

                Green<br>Flag

            </h1>

        </div>

        <div class="right-nav">

            <button id="themeToggle">

                <i class="fa-solid fa-moon"></i>

            </button>

        </div>

    </header>

    <main class="auth-page admin-page">

        <div class="auth-card">

            <div class="auth-logo">

                <i class="fa-solid fa-user-shield"></i>

            </div>

            <span class="auth-badge">Administrator Access</span>

            <h1>

                Admin Portal

            </h1>

            <p class="subtitle">

                Sign in to manage spots, reviews, users, and platform content.

            </p>

            <?php

            if (isset($_SESSION["error"])) {

                ?>

                <div class="auth-error">

                    <?= $_SESSION["error"] ?>

                </div>

                <?php

                unset($_SESSION["error"]);

            }

            ?>

            <form action="login_process.php" method="POST">

                <div class="input-group">

                    <label>

                        Admin Email

                    </label>

                    <input type="email" name="email" placeholder="admin@greenflag.com" required>

                </div>

                <div class="input-group">

                    <label>

                        Password

                    </label>

                    <input type="password" id="password" name="password" placeholder="Enter your password" required>

                    <label class="checkbox">
                      <input type="checkbox" id="check" > Show Password  
                    </label>

                </div>

                <button class="auth-btn" type="submit">

                    Sign In as Admin

                </button>

            </form>

            <div class="auth-divider">

                <span>OR</span>

            </div>

            <a href="../login.php" class="admin-login-link">

                <i class="fa-solid fa-arrow-left"></i>

                Return to User Login

            </a>

        </div>

    </main>

    <script src="../js/darkmode.js"></script>
    <script src="js/admin.js"></script>

</body>

</html>
