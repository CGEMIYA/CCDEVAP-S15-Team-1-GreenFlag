<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Green Flag</title>

    <!-- CSS -->

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Font Awesome -->

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
                 <a href="index.php">
                     <img src="photos/greenflag.png" alt="Green Flag Logo" class="nav-logo-img">
                 </a>
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

                <i class="fa-solid fa-user-plus"></i>

            </div>

            <h1>

                Create an Account

            </h1>

            <p class="subtitle">

                Join Green Flag and discover the best study spots,
                cafés, and hangout locations around campus.

            </p>

            <?php

            if (isset($_SESSION["error"])) {

                ?>

                <div class="auth-error">

                    <?= $_SESSION["error"]; ?>

                </div>

                <?php

                unset($_SESSION["error"]);

            }

            ?>

            <form id="registerForm" action="process/register_process.php" method="POST">

                <!-- Full Name -->

                <div class="input-group">

                    <label>

                        Full Name

                    </label>

                    <input type="text" id="fullName" name="full_name" placeholder="Juan Dela Cruz" required>

                </div>

                <!-- Email -->

                <div class="input-group">

                    <label>

                        DLSU Email

                    </label>

                    <input type="email" id="email" name="email" placeholder="juan.delacruz@dlsu.edu.ph" required>

                    <small id="emailMessage"></small>

                </div>

                <!-- Password -->

                <div class="input-group">

                    <label>

                        Password

                    </label>

                    <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required>

                </div>

                <!-- Confirm Password -->

                <div class="input-group">

                    <label>

                        Confirm Password

                    </label>

                    <input type="password" id="confirmPassword" name="confirm_password"
                        placeholder="Re-enter your password" required>

                    <small id="passwordMessage"></small>

                </div>

                <!-- Terms -->

                <div class="checkbox-group">

                    <input type="checkbox" id="terms" name="terms" required>

                    <label for="terms">

                        I agree to the Green Flag Community Guidelines.

                    </label>

                </div>

                <button class="auth-btn" type="submit">

                    Create Account

                </button>

            </form>

            <div class="auth-divider">

                <span>OR</span>

            </div>

            <p class="bottom-text">

                Already have an account?

            </p>

            <button class="secondary-btn" onclick="window.location.href='login.php'">

                Login Instead

            </button>

        </div>

    </main>

    <script src="js/darkmode.js"></script>

    <script src="js/register.js"></script>

</body>

</html>