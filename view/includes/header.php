<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Flag</title>

    <link rel="stylesheet" href="../view/css/global.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../view/css/home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../view/css/about.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../view/css/spot.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../view/css/responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

    <!-- NAVBAR (Spans full width at top) -->
    <header>

        <div class="left-nav">
            <button class="menu-btn" id="menuBtn">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="logo">
                <a href="../view/index.php">
                    <img src="../view/photos/greenflag.png" alt="Green Flag Logo" class="nav-logo-img">
                </a>
            </h1>
        </div>

        <!-- SEARCH FORM -->
        <form method="GET" action="viewAll.php" class="search-container">
            <input type="text" name="search" id="searchInput" placeholder="Search spots..." autocomplete="off" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="search-results" id="searchResults"></div>
            <button type="submit" style="display: none;">Search</button>
        </form>

        <div class="right-nav">
            <button id="themeToggle">
                <i class="fa-solid fa-moon"></i>
            </button>
            <a href="../view/login.php">
                <i class="fa-regular fa-user"></i> Login
            </a>
            <span>|</span>
            <a href="../view/register.php">Sign Up</a>
        </div>
    </header>

    <!-- PAGE LAYOUT WRAPPER (Renders Sidebar + Main content side-by-side) -->
    <div class="page-layout">

        <!-- SIDEBAR OVERLAY (Mobile only) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-profile">
                <div class="profile-picture">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="profile-info">
                    <h3>You are not signed in</h3>
                    <p>Login to unlock reviews, save reviews, and more.</p>
                </div>
            </div>

            <div class="sidebar-links">
                <a href="../view/login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                <a href="../view/register.php"><i class="fa-solid fa-user-plus"></i> Sign Up</a>
            </div>
            <div class="sidebar-divider"></div>
            <div class="sidebar-links">
                <a href="../view/index.php"><i class="fa-solid fa-house"></i> Home</a>
                <a href="../view/coinflip.php"><i class="fa-solid fa-coins"></i> Coin Flip</a>
                <a href="../view/aboutus.php"><i class="fa-solid fa-circle-info"></i> About Green Flag</a>
            </div>
        </aside>