<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Green Flag | Spot Details</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/spot.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

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

                <a href="#">
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

            <section class="spot-page">

                <div class="gallery">

                    <img id="mainImage">

                    <div class="thumbnail-row">

                        <img class="thumb">
                        <img class="thumb">
                        <img class="thumb">
                        <img class="thumb">

                    </div>

                </div>


                <div class="spot-info">

                    <h1 id="spotName"></h1>

                    <p id="spotLocation"></p>

                    <div class="rating">

                        <span id="rating"></span>

                        <span id="price"></span>

                    </div>

                    <p id="description"></p>

                    <div class="details">

                        <p id="hours"></p>

                        <p id="noise"></p>

                        <p id="privacy"></p>

                    </div>

                    <div id="tags">

                    </div>

                </div>

            </section>

            <section class="reviews">

                <div class="review-input">

                    <div class="review-left">

                        <h2>Give a Review!</h2>

                        <textarea id="reviewText" placeholder="Share your experience..."></textarea>

                        <p class="login-note">
                            🔒 Please log in to post a review.
                        </p>

                    </div>

                    <div class="post-panel">

                        <div class="flag-buttons">

                            <button class="flag green">🟢</button>

                            <button class="flag red">🔴</button>

                        </div>

                        <button class="postBtn" id="postReview">
                            POST
                        </button>

                    </div>

                </div>

                <div id="reviewsContainer"></div>

            </section>

        </main>

        <script src="js/spots.js"></script>
        <script src="js/darkmode.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/search.js"></script>
        <script src="js/spot.js"></script>
        <script src="js/reviews.js"></script>


    </body>