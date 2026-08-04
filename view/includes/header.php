<?php
// BEGIN SESSION CHECK
// don't accidentally start twice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($extra_css)) {
    $extra_css = [];
}

if (!isset($active_nav)) {
    $current_page = basename($_SERVER['PHP_SELF'] ?? 'index.php');

    if ($current_page === 'coinflip.php') {
        $active_nav = 'coinflip';
    } elseif ($current_page === 'aboutus.php') {
        $active_nav = 'about';
    } elseif ($current_page === 'analytics.php' || $current_page === 'reviews.php' || $current_page === 'spots.php' || $current_page === 'tags.php' || $current_page === 'users.php') {
        $active_nav = 'admin';
    } else {
        $active_nav = 'home';
    }
}
?>
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
    <?php foreach ($extra_css as $css) : ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($css, ENT_QUOTES); ?>">
    <?php endforeach; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

    <!-- NAVBAR -->
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
            
            <!-- UPDATE NAVBAR WITH SESSION -->
            <?php if (isset($_SESSION["user_id"])): ?>
                <!-- If Logged in -->
                <span style="font-weight: 600; color: var(--primary);">Hi, <?= htmlspecialchars($_SESSION["full_name"]); ?></span>
                <span>|</span>
                <a href="../model/process/logout_process.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            <?php else: ?>
                <!-- If NOT Logged in -->
                <a href="../view/login.php"><i class="fa-regular fa-user"></i> Login</a>
                <span>|</span>
                <a href="../view/register.php">Sign Up</a>
            <?php endif; ?>

        </div>
    </header>

    <!-- This opens layout for the entire page -->
    <div class="page-layout">

    <!-- SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-profile">
            <div class="profile-picture">
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="profile-info">
                <!-- UPDATE SIDEBAR WITH SESSION -->
                <?php if (isset($_SESSION["user_id"])): ?>
                    <!-- If Logged in -->
                    <h3><?= htmlspecialchars($_SESSION["full_name"]); ?></h3>
                    <p><?= htmlspecialchars($_SESSION["email"]); ?></p>
                <?php else: ?>
                    <!-- If NOT Logged in -->
                    <h3>You are not signed in</h3>
                    <p>Login to post reviews, save your favorite spots, and discover your next Green Flag.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="sidebar-links">
                <!-- SIDEBAR BUTTONS LOGGED IN & LOGGED OUT-->
            <?php if (isset($_SESSION["user_id"])): ?>
                <!-- If Logged in -->
                <a href="../model/process/logout_process.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            <?php else: ?>
                <!-- If NOT Logged in -->
                <a href="../view/login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                <a href="../view/register.php"><i class="fa-solid fa-user-plus"></i> Sign Up</a>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin"): ?>
            <div class="sidebar-links">
                <a href="../view/admin/analytics.php" class="<?php echo $active_nav === 'admin' ? 'active' : ''; ?>" aria-current="<?php echo $active_nav === 'admin' ? 'page' : 'false'; ?>">
                    <i class="fa-solid fa-gauge"></i> Admin Dashboard
                </a>
            </div>
        <?php endif; ?>

        <div class="sidebar-divider"></div>
        <div class="sidebar-links">
            <a href="../view/index.php" class="<?php echo $active_nav === 'home' ? 'active' : ''; ?>" aria-current="<?php echo $active_nav === 'home' ? 'page' : 'false'; ?>">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <a href="../view/coinflip.php" class="<?php echo $active_nav === 'coinflip' ? 'active' : ''; ?>" aria-current="<?php echo $active_nav === 'coinflip' ? 'page' : 'false'; ?>">
                <i class="fa-solid fa-coins"></i> Coin Flip
            </a>
            <a href="../view/aboutus.php" class="<?php echo $active_nav === 'about' ? 'active' : ''; ?>" aria-current="<?php echo $active_nav === 'about' ? 'page' : 'false'; ?>">
                <i class="fa-solid fa-circle-info"></i> About Green Flag
            </a>
        </div>
    </aside>