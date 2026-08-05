<?php 
    // Detects the file name of the currently active page (e.g., 'users.php', 'spots.php')
    $current_page = basename($_SERVER['PHP_SELF']); 
?>

<div class="sidebar">
    <div class="sidebar-header">
        <a href="../../view/index.php">
            <img src="greenflag.png" alt="Logo">
        </a>
     
    </div>

    <nav>
        <a href="analytics.php" class="<?= ($current_page == 'analytics.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-line"></i>
            Dashboard
        </a>
        <a href="users.php" class="<?= ($current_page == 'users.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-users"></i>
            Users
        </a>
        <a href="spots.php" class="<?= ($current_page == 'spots.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-location-dot"></i>
            Spots
        </a>
        <a href="reviews.php" class="<?= ($current_page == 'reviews.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-comments"></i>
            Reviews
        </a>
        <a href="tags.php" class="<?= ($current_page == 'tags.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-tags"></i>
            Tags
        </a>
        <a href="../aboutus.php" class="<?= ($current_page == 'aboutus.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-circle-info"></i>
            About Us
        </a>
        <hr>
        <a href="../../model/process/logout_process.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </nav>

</div>