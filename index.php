<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Flag</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <header>

        <div class="left-nav">

            <button class="menu-btn" id="menuBtn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <h1 class="logo">

                <a href="index.php">Green<br>Flag</a>
            </h1>

        </div>

        <div class="search-container">

            <input type="text" id="searchInput" placeholder="Search spots...">

            <div class="search-results" id="searchResults"></div>

        </div>

        <div class="right-nav">

            <button id="themeToggle">
                <i class="fa-solid fa-moon"></i>
            </button>

            <a href="login.php">
                <i class="fa-regular fa-user"></i>
                Login
            </a>

            <span>|</span>

            <a href="register.php">
                Sign Up
            </a>

        </div>

    </header>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-profile">

            <div class="profile-picture">
                <i class="fa-regular fa-user"></i>
            </div>

            <div class="profile-info">

                <h3>You are not signed in</h3>

                <p>Login to unlock reviews, favorites, and more.</p>

            </div>

        </div>

        <div class="sidebar-links">

            <a href="login.php">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </a>

            <a href="register.php">
                <i class="fa-solid fa-user-plus"></i>
                Sign Up
            </a>

        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-links">

            <a href="index.php">
                <i class="fa-solid fa-house"></i>
                Home
            </a>

            <a href="#">
                <i class="fa-regular fa-heart"></i>
                Favorites
            </a>

            <a href="coinflip.php">
                <i class="fa-solid fa-coins"></i>
                Coin Flip
            </a>

            <a href="#">
                <i class="fa-solid fa-circle-info"></i>
                About Green Flag
            </a>

        </div>

    </aside>


    <main>

        <section class="popular">

            <div class="section-header">
                <h2>Popular Now</h2>
                <a href="#">View All</a>
            </div>

            <div class="carousel">

                <button class="arrow" id="prevBtn">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="cards-container" id="cardsContainer">

                </div>

                <button class="arrow" id="nextBtn">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

            </div>

        </section>

    </main>

    <script src="js/spots.js"></script>
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/search.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/homepage.js"></script>

</body>

</html>