<?php
<<<<<<< HEAD
require_once (__DIR__ . '/../model/config/database.php');
=======
require_once(__DIR__ . '/../model/config/database.php'); //require_once 'config/database.php';
>>>>>>> deac663c78c363fd8f5f7e2c2cdff49621506201

$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Fetch main grid data
$query = "
    SELECT s.id, s.name, s.location, s.price, s.description, s.image,
           IFNULL(ROUND(AVG(r.rating), 1), 0) as avg_rating,
           COUNT(r.id) as review_count
    FROM spots s
    LEFT JOIN reviews r ON s.id = r.spot_id
    WHERE s.name LIKE ?
    GROUP BY s.id
    ORDER BY avg_rating DESC
";

$stmt = $pdo->prepare($query);
$searchWildcard = "%" . $searchTerm . "%";
$stmt->execute([$searchWildcard]);
$spots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch data for the live search dropdown
$allQuery = "SELECT id, name, location FROM spots";
$allStmt = $pdo->query($allQuery);
$allSpots = $allStmt->fetchAll(PDO::FETCH_ASSOC);

$priceMap = [
    'Free' => 'Free',
    'Low' => '$',
    'Medium' => '$$',
    'High' => '$$$'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Flag - View All</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <!-- NAVBAR COPIED FROM INDEX.PHP -->
    <header>
        <div class="left-nav">
            <button class="menu-btn" id="menuBtn">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="logo">
                <a href="index.php">Green<br>Flag</a>
            </h1>
        </div>

        <form method="GET" action="viewAll.php" class="search-container">
            <input type="text" id="searchInput" name="search" placeholder="Search spots..." autocomplete="off"
                value="<?php echo htmlspecialchars($searchTerm); ?>">
            <div class="search-results" id="searchResults"></div>
            <button type="submit" style="display: none;">Search</button>
        </form>

        <div class="right-nav">
            <button id="themeToggle">
                <i class="fa-solid fa-moon"></i>
            </button>
            <a href="login.php">
                <i class="fa-regular fa-user"></i> Login
            </a>
            <span>|</span>
            <a href="register.php">Sign Up</a>
        </div>
    </header>

    <!-- SIDEBAR COPIED FROM INDEX.PHP -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </a>
            <a href="register.php">
                <i class="fa-solid fa-user-plus"></i> Sign Up
            </a>
        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-links">
            <a href="index.php">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <a href="#">
                <i class="fa-regular fa-heart"></i> Favorites
            </a>
            <a href="coinflip.php">
                <i class="fa-solid fa-coins"></i> Coin Flip
            </a>
            <a href="#">
                <i class="fa-solid fa-circle-info"></i> About Green Flag
            </a>
        </div>
    </aside>

    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->
    <main>
        <div class="popular">
            <section class="section-header">
                <h2><?php echo $searchTerm ? "Search Results for '" . htmlspecialchars($searchTerm) . "'" : "All Spots"; ?>
                </h2>
                <a href="index.php">Popular Now</a>
            </section>

            <div class="cards-container" style="flex-wrap: wrap;">
                <?php if (count($spots) > 0): ?>
                    <?php foreach ($spots as $spot): ?>
                        <div class="card"
                            onclick="window.location.href='spot.php?id=<?php echo htmlspecialchars($spot['id'] - 1); ?>'">

                            <?php if (!empty($spot['image'])): ?>
                                <img src="<?php echo htmlspecialchars($spot['image']); ?>"
                                    alt="<?php echo htmlspecialchars($spot['name']); ?>">
                            <?php else: ?>
                                <div
                                    style="width: 100%; height: 220px; display: flex; align-items: center; justify-content: center; background: #eee;">
                                    ✕ No Image</div>
                            <?php endif; ?>

                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($spot['name']); ?></h3>
                                <p class="location">📍 <?php echo htmlspecialchars($spot['location']); ?></p>

                                <div class="info">
                                    <span>⭐ <?php echo htmlspecialchars($spot['avg_rating']); ?>
                                        (<?php echo htmlspecialchars($spot['review_count']); ?>)</span>
                                    <span><?php echo $priceMap[$spot['price']]; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No spots found matching your search.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Passes database array to your search.js file
        const spotsData = <?php echo json_encode($allSpots); ?>;
    </script>

    <!-- Using the exact scripts from your index.php -->
    <script src="js/spots.js"></script>
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/search.js"></script>
</body>

</html>