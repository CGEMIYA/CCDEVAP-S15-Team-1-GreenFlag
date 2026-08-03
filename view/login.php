<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Green Flag</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/responsive.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <header>

        <div class="left-nav">

            <!-- Replaced old button -->
            <button class="menu-btn" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i>
            </button>

            <!-- Replace the old h1 with this -->
            <h1 class="logo">
                 <a href="index.php">Green<br>Flag</a>
            </h1>

        </div>

        <div class="right-nav">

            <button id="themeToggle">

                <i class="fa-solid fa-moon"></i>

            </button>

        </div>

    </header>

    <main class="auth-page">

        <div class="auth-card">

            <div class="auth-logo">

                <i class="fa-solid fa-seedling"></i>

            </div>

            <h1>

                Welcome Back

            </h1>

            <p class="subtitle">

                Login to review spots, save favorites,
                and discover your next Green Flag.

            </p>

            <?php

            if (isset($_SESSION["success"])) {

                ?>

                <div class="auth-success">

                    <?= $_SESSION["success"]; ?>

                </div>

                <?php

                unset($_SESSION["success"]);

            }

            ?>

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
            <form id="loginForm" action="../model/process/login_process.php" method="POST">

                <div class="input-group">

                    <label>

                        DLSU Email

                    </label>

                    <input type="email" id="email" name="email" placeholder="juan.delacruz@dlsu.edu.ph" required>

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

                    Login

                </button>

            </form>

            <div class="auth-link-row">

                <a href="admin/login.php" class="admin-login-link">

                    <i class="fa-solid fa-shield-halved"></i>

                    Admin Login

                </a>

            </div>

            <div class="auth-divider">

                <span>OR</span>

            </div>

            <p class="bottom-text">

                Don't have an account yet?

            </p>

            <button class="secondary-btn" onclick="window.location.href='register.php'">

                Create Account

            </button>

        </div>

    </main>

    <script src="js/darkmode.js"></script>
    <script src="js/login.js"></script>

</body>

</html>